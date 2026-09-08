<?php

namespace Jeffersongoncalves\Resend\Tests;

use Jeffersongoncalves\Resend\ResendServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ResendServiceProvider::class,
        ];
    }
}
