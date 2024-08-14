<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

enum MessageStatus: string
{
    case HARD_FAIL = 'HardFail';
    case SOFT_FAIL = 'SoftFail';
    case HELD      = 'Held';

    case SENT = 'Sent';
}
