<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 11:46 PM
 */

namespace Zondario\Core\Http;


class SupportedContentTypes
{
    const SUPPORTED_CONTENT_TYPES = [
        'application/json' => 'json',
        'application/xml' => 'xml',
        'json' => 'json',
        'xml' => 'xml'
    ];

    public static function isTypeSupported($contentType)
    {
        return in_array($contentType, array_keys(self::SUPPORTED_CONTENT_TYPES));
    }
    public static function getSerializerRepresentationOfContentType($contentType)
    {
        if (!self::isTypeSupported($contentType)) {
            return null;
        }
        return self::SUPPORTED_CONTENT_TYPES[$contentType];
    }
}