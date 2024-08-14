<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class MessageStatusEventPayload
{
    public function __construct(
        public MessageStatus $status,
        public string $details,
        public string $output,
        public float $time,
        public bool $sent_with_ssl,
        public float $timestamp,
        public Message $message
    ) {
    }
}
