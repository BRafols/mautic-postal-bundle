<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Tests\Unit\DTO;

use MauticPlugin\PostalBundle\DTO\MessageStatus;
use MauticPlugin\PostalBundle\DTO\MessageStatusEvent;
use MauticPlugin\PostalBundle\DTO\MessageStatusEventPayload;

class MessageStatusEventMother
{
    public static function create(
        ?MessageStatus $status = null,
        ?string $details = null,
        ?string $output = null,
        ?float $time = null,
        ?bool $sent_with_ssl = null,
        ?float $timestamp = null,
        ?string $to = null,
    ): MessageStatusEvent {
        return new MessageStatusEvent(
            event: 'MessageDeliveryFailed',
            timestamp: 1477945177.12994,
            payload: new MessageStatusEventPayload(
                status: MessageStatus::HARD_FAIL,
                details: $details ?? 'Permanent SMTP delivery error when sending to 185.23.70.7:25 (mail.zaporeaz.com). Recipient added to suppression list (too many hard fails)',
                output: $output ?? "550-The mail server could not deliver mail to zaporeaz@zaporeaz.com.  The\n550-account or domain may not exist, they may be blacklisted, or missing the\n550 proper dns entries.",
                time: 0.22,
                sent_with_ssl: true,
                timestamp: 1477945177.12994,
                message: MessageMother::create(
                    $to
                )
            ),
            uuid: '1edb6f86-c43c-4b0a-8b67-4bab0f6ab1ac'
        );
    }
}
