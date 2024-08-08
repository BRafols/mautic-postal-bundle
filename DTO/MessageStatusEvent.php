<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class MessageStatusEvent
{
	public function __construct(
		public MessageStatus $status,
		public string $details,
		public string $output,
		public float $time,
        #[SerializedName('sent_with_ssl')]
		public bool $sentWithSsl,
		public float $timestamp,
		public Message $message
	) {
	}
}
