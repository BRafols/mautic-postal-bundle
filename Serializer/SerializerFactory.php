<?php

declare(strict_types=1);

namespace MauticPlugin\PostalBundle\Serializer;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    public static function create(): SerializerInterface
    {
        return SerializerBuilder::create()->build();
    }
}
