<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Tests\Unit\Helper;

use MauticPlugin\PostalBundle\Helper\MessageStatusEventCommentCreator;
use MauticPlugin\PostalBundle\Tests\Unit\DTO\MessageStatusEventMother;
use PHPUnit\Framework\TestCase;

class MessageStatusEventCommentCreatorTest extends TestCase
{
    public function testItWorksWithMessageStatusEvent(): void
    {
        $details = 'Details';
        $output  = 'Output';
        $event   = MessageStatusEventMother::create(
            details: $details,
            output: $output,
        );
        $creator = new MessageStatusEventCommentCreator();
        $comment = $creator->for($event);
        $this->assertStringContainsString($details, $comment);
        $this->assertStringContainsString($output, $comment);
    }
}
