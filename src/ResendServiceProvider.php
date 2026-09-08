<?php

namespace Jeffersongoncalves\Resend;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ResendServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-resend')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
