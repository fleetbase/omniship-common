<?php

namespace Omniship\Common;

class AbstractSerializer implements SerializerInterface
{
    protected array $attributes = [];

    public function __construct(?array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function serialize()
    {
        $serializerMethods = $this->getSerializerMethods();

        foreach ($this->attributes as $key => $value) {
            $this->attributes[$key] = $this->{$serializerMethods[$key]}($value);
        }

        return $this->attributes;
    }

    private function getSerializerMethods(): array
    {
        $serializerMethods = [];

        foreach (array_keys($this->attributes) as $key) {
            $attributeSerializerMethod = 'serialize' . Utils::classify($key);

            if (method_exists($this, $attributeSerializerMethod)) {
                $serializerMethods[$key] = $attributeSerializerMethod;
            } else {
                $serializerMethods[$key] = function ($attr) {
                    return $attr;
                };
            }
        }

        return $serializerMethods;
    }

    public function toJson()
    {
        return json_encode($this->attributes);
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function output()
    {
        return (object) $this->attributes;
    }
}
