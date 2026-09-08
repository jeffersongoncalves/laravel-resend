<?php

namespace JeffersonGoncalves\Resend;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ResendServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('resend')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Resend::class, function () {
            return new Resend(
                (string) config('resend.api_key'),
                (string) config('resend.base_url', 'https://api.resend.com'),
            );
        });
    }
}
