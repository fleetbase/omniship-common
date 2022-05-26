<?php

namespace Omniship\Common;

use Omniship\Common\Service;
use Omniship\Common\Utils;

class Resolver
{
    private static function internalResolver($class, ...$params)
    {
        if (class_exists($class)) {
            return new $class(...$params);
        }

        return null;
    }

    public static function resolveFromString(string $name, ...$params)
    {
        $class = static::getClassName(explode(':', $name));

        return static::internalResolver($class, ...$params);
    }

    public static function resolveService(string $name, ...$params): ?Service
    {
        $class = static::getClassName('service', $name);

        return static::internalResolver($class, ...$params);
    }

    public static function resolve(string $name, ...$params)
    {
        return static::resolveFromString($name, ...$params);
    }

    public static function getClassName()
    {
        $namespace = '\\Omniship\\';
        $args = func_get_args();
        $count = count($args);

        for ($i = 0; $i < $count; $i++) {
            $class = $args[$i];
            $last = $count === $i + 1;

            $namespace .= Utils::classify($class);

            if (!$last) {
                $namespace .= '\\';
            }
        }

        return $namespace;
    }
}
