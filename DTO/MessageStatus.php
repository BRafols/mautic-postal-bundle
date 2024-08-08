<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

class MessageStatus
{
    public const MESSAGE_SENT = 'MessageSent';
    public const MESSAGE_DELAYED = 'MessageDelayed';
    public const MESSAGE_DELIVERY_FAILED = 'MessageDeliveryFailed';
    public const MESSAGE_HELD = 'MessageHeld';

    /**
     * Get all the possible values of the message status.
     *
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::MESSAGE_SENT,
            self::MESSAGE_DELAYED,
            self::MESSAGE_DELIVERY_FAILED,
            self::MESSAGE_HELD,
        ];
    }

    /**
     * Validate if a given value is a valid message status.
     *
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::getValues(), true);
    }
}
