<?php

use JeffersonGoncalves\Resend\Facades\Resend;
use JeffersonGoncalves\Resend\Resend as ResendManager;
use JeffersonGoncalves\Resend\Resources\Emails;

it('registers the manager as a singleton', function () {
    expect(app(ResendManager::class))->toBe(app(ResendManager::class));
});

it('resolves the facade to the manager', function () {
    expect(Resend::emails())->toBeInstanceOf(Emails::class);
});

it('publishes the config file', function () {
    expect(config('resend.base_url'))->toBe('https://api.resend.com');
});
