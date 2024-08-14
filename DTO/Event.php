<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\DTO;

enum Event: string
{
    case DELIVERY_FAILED = 'MessageDeliveryFailed';
    case BOUNCED         = 'MessageBounced';
}
