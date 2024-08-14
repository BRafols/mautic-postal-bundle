<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class MessageBouncedEventPayload
{
    public function __construct(
        public Message $original_message,
        public Message $bounce
    ) {
    }
}
