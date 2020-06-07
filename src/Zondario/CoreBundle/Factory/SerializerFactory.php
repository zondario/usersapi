<?php

namespace Zondario\CoreBundle\Factory;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    public static function getDefaultSerializer()
    {
        return SerializerBuilder::create()->build();
    }
}