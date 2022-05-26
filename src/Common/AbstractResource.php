<?php

namespace Omniship\Common;

class AbstractResource
{
    public string $serializer;
    private array $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = (array) $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function serialize()
    {
        if (class_exists(static::$serializer)) {
            return Resolver::resolveSerializer(static::$serializer, $this->attributes)->serialize();
        }
        return Resolver::resolveSerializer(static::class, $this->attributes)->serialize();
    }
}
