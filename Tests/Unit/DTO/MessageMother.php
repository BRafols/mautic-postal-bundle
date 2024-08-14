<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Tests\Unit\DTO;

use MauticPlugin\PostalBundle\DTO\Message;

class MessageMother
{
    public static function create(
        ?string $to = null,
    ): Message {
        return new Message(
            id: 12345,
            token: 'abcdef123',
            direction: 'outgoing',
            to: $to ?? 'test@example.com',
            subject: 'Welcome to AwesomeApp',
            timestamp: 1477945177.12994,
            from: 'sales@awesomeapp.com',
            spam_status: 'NotSpam',
            tag: 'welcome',
            message_id: '5817a64332f44_4ec93ff59e79d154565eb@app34.mail',
        );
    }
}
