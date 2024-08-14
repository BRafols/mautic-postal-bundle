<?php

declare(strict_types=1);

namespace Functional;

use JMS\Serializer\SerializerBuilder;
use Mautic\CoreBundle\Test\MauticMysqlTestCase;
use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\PostalBundle\Tests\Unit\DTO\MessageBouncedEventMother;
use MauticPlugin\PostalBundle\Tests\Unit\DTO\MessageStatusEventMother;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class CallbackSubscriberTest extends MauticMysqlTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function tsestPostalTransportNotConfigured(): void
    {
        $this->client->request(Request::METHOD_POST, '/mailer/callback');
        $response = $this->client->getResponse();
        Assert::assertSame('No email transport that could process this callback was found', $response->getContent());
        Assert::assertSame(404, $response->getStatusCode());
    }

    public function testPostalHandlesMessageStatusWebhook(): void
    {
        $email = 'contact@an.email';
        $event = MessageStatusEventMother::create(
            to: $email,
        );
        $serializer = SerializerBuilder::create()->enableEnumSupport()->build();
        $payload    = $serializer->serialize($event, 'json');

        $contact = $this->createContact($email);
        $this->em->flush();

        $this->client->request(
            Request::METHOD_POST,
            '/mailer/callback',
            [],
            [],
            ['Content-Type' => 'application/json'],
            $payload
        );
        $response = $this->client->getResponse();

        $dnc = $contact->getDoNotContact()->current();
        $now = (new \DateTime())->add(new \DateInterval('PT1S'));

        Assert::assertSame('Callback processed', $response->getContent());
        Assert::assertSame(200, $response->getStatusCode());
        Assert::assertSame('email', $dnc->getChannel());
        Assert::assertEqualsWithDelta($now, $dnc->getDateAdded(), 2);
        Assert::assertSame($contact, $dnc->getLead());
    }

    public function testPostalHandlesMessageBouncedWebhook(): void
    {
        $email = 'contact@an.email';
        $event = MessageBouncedEventMother::create(
            to: $email,
        );
        $serializer = SerializerBuilder::create()->enableEnumSupport()->build();
        $payload    = $serializer->serialize($event, 'json');

        $contact = $this->createContact($email);
        $this->em->flush();

        $this->client->request(
            Request::METHOD_POST,
            '/mailer/callback',
            [],
            [],
            ['Content-Type' => 'application/json'],
            $payload
        );
        $response = $this->client->getResponse();

        $dnc          = $contact->getDoNotContact()->current();
        $now          = new \DateTime();

        Assert::assertSame('Callback processed', $response->getContent());
        Assert::assertSame(200, $response->getStatusCode());
        Assert::assertSame('email', $dnc->getChannel());
        Assert::assertEqualsWithDelta($now, $dnc->getDateAdded(), 2);
        Assert::assertSame($contact, $dnc->getLead());
    }

    private function createContact(string $email): Lead
    {
        $lead = new Lead();
        $lead->setEmail($email);

        $this->em->persist($lead);

        return $lead;
    }
}
