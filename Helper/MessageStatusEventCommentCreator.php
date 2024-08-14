<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Helper;

use MauticPlugin\PostalBundle\DTO\MessageStatusEvent;

class MessageStatusEventCommentCreator
{
    public function for(MessageStatusEvent $event): string
    {
        return sprintf('%s - %s', $event->payload->details, $event->payload->output);
    }
}
