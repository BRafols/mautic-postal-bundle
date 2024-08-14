<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class Message
{
    public function __construct(
        public int $id,
        public string $token,
        public string $direction,
        public string $to,
        public string $subject,
        public float $timestamp,
        public ?string $from = null,
        public ?string $spam_status = null,
        public ?string $tag = null,
        public ?string $message_id = null,
    ) {
    }
}
