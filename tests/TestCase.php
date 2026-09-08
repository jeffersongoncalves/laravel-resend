<?php

namespace JeffersonGoncalves\Resend\Tests;

use JeffersonGoncalves\Resend\ResendServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ResendServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('resend.api_key', 're_test_key');
    }
}
