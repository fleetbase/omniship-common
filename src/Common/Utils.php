<?php

namespace Omniship\Common;

use Stringy\Stringy as S;

class Utils
{
    public static function classify($string)
    {
        return static::stringy($string)->upperCamelize();
    }

    public static function stringy($string)
    {
        return S::create($string);
    }

    public static function removeElementFromArray(array $array, $element)
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            if ($value !== $element) {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }

    public static function stringContains($haystack, string $needle)
    {
        return is_string($haystack) && $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
