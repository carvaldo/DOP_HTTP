<?php /** @noinspection PhpUnused */

namespace Doap\Client;

abstract class ContentType
{
    private $name;

    public function __construct($content_type)
    {
        $this->name = $content_type;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function typeJson(): ContentType {
        return new ContentTypeJson();
    }
}