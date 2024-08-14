<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Tests\Unit\DTO;

use MauticPlugin\PostalBundle\DTO\MessageBouncedEvent;
use MauticPlugin\PostalBundle\DTO\MessageBouncedEventPayload;
use MauticPlugin\PostalBundle\DTO\MessageStatus;

class MessageBouncedEventMother
{
    public static function create(
        ?MessageStatus $status = null,
        ?string $details = null,
        ?string $output = null,
        ?float $time = null,
        ?bool $sent_with_ssl = null,
        ?float $timestamp = null,
        ?string $to = null,
    ): MessageBouncedEvent {
        return new MessageBouncedEvent(
            event: 'MessageBounced',
            timestamp: 1477945177.12994,
            payload: new MessageBouncedEventPayload(
                original_message: MessageMother::create(
                    $to
                ),
                bounce: MessageMother::create(
                    to: 'test@postal.com'
                )
            ),
            uuid: '1edb6f86-c43c-4b0a-8b67-4bab0f6ab1ac'
        );
    }
}
