<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Message
{
	public function __construct(
		public int $id,
		public string $token,
		public string $direction,
        #[SerializedName('message_id')]
		public ?string $messageId = null,
		public string $to,
		public string $from,
		public string $subject,
		public float $timestamp,
        #[SerializedName('spam_status')]
		public ?string $spamStatus = null,
		public ?string $tag = null,
	) {
	}
}
