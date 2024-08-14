<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class MessageStatusEvent
{
    public function __construct(
        public string $event,
        public float $timestamp,
        public MessageStatusEventPayload $payload,
        public string $uuid
    ) {
    }
}
