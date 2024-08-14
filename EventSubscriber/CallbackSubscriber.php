<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\EventSubscriber;

use JMS\Serializer\SerializerBuilder;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\TransportWebhookEvent;
use Mautic\EmailBundle\Model\TransportCallback;
use Mautic\LeadBundle\Entity\DoNotContact;
use MauticPlugin\PostalBundle\DTO\Event;
use MauticPlugin\PostalBundle\DTO\MessageBouncedEvent;
use MauticPlugin\PostalBundle\DTO\MessageStatus;
use MauticPlugin\PostalBundle\DTO\MessageStatusEvent;
use MauticPlugin\PostalBundle\Helper\MessageStatusEventCommentCreator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallbackSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private TransportCallback $transportCallback,
        private MessageStatusEventCommentCreator $commentCreator,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EmailEvents::ON_TRANSPORT_WEBHOOK => 'processCallbackRequest',
        ];
    }

    /**
     * @throw
     */
    private function validate(Request $request): MessageStatusEvent|MessageBouncedEvent
    {
        $serializer = SerializerBuilder::create()->enableEnumSupport()->build();
        try {
            $event = Event::from($request->toArray()['event']);

            return match ($event) {
                Event::DELIVERY_FAILED => $serializer->deserialize($request->getContent(), MessageStatusEvent::class, 'json'),
                Event::BOUNCED         => $serializer->deserialize($request->getContent(), MessageBouncedEvent::class, 'json'),
            };
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Invalid request');
        }
    }

    private function handleDefault(object $message, TransportWebhookEvent $event): void
    {
        $event->setResponse(new Response('Callback status processed'));
    }

    private function handleMessageStatusEvent(MessageStatusEvent $message): void
    {
        if (MessageStatus::HARD_FAIL !== $message->payload->status) {
            return;
        }

        $email    = $message->payload->message->to;
        $comments = $this->commentCreator->for($message);

        $this->transportCallback->addFailureByAddress($email, $comments, DoNotContact::BOUNCED);
    }

    private function handleMessageBouncedEvent(MessageBouncedEvent $event): void
    {
        $email    = $event->payload->original_message->to;
        $comments = $event->payload->bounce->subject;

        $this->transportCallback->addFailureByAddress($email, $comments, DoNotContact::BOUNCED);
    }

    public function processCallbackRequest(TransportWebhookEvent $event): void
    {
        try {
            $message = $this->validate($event->getRequest());

            match (get_class($message)) {
                MessageStatusEvent::class  => $this->handleMessageStatusEvent($message),
                MessageBouncedEvent::class => $this->handleMessageBouncedEvent($message),
                default                    => $this->handleDefault($message, $event),
            };

            $event->setResponse(new Response('Callback processed'));
        } catch (\InvalidArgumentException $e) {
            return;
        }
    }
}
