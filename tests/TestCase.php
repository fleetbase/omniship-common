<?php

declare(strict_types=1);

namespace Fleetbase\Omniship\Test;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Dotenv\Dotenv;

class TestCase extends MockeryTestCase
{
    public function __construct()
    {
        parent::__construct();
        static::__loadEnv();
    }

    private static function __loadEnv()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test');
        return $dotenv->load();
    }
}
