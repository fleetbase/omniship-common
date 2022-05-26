<?php

namespace Omniship\Common;

interface SerializerInterface
{
    public function serialize();
    public function output();
    public function toJson();
    public function toArray();
}
