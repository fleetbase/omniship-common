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
}
