<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class MessageBouncedEvent
{
    public function __construct(
        public Message $originalMessage,
        public Message $bounce)
    {
    }
}