<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists webhooks', function () {
    Http::fake(['api.resend.com/webhooks' => Http::response(['data' => [['id' => 'whk_1']]])]);

    expect(Resend::webhooks()->list()['data'][0]['id'])->toBe('whk_1');
});

it('gets a webhook', function () {
    Http::fake(['api.resend.com/webhooks/whk_1' => Http::response(['id' => 'whk_1', 'url' => 'https://example.com/hook'])]);

    expect(Resend::webhooks()->get('whk_1')['url'])->toBe('https://example.com/hook');
});

it('creates a webhook with default events', function () {
    Http::fake(['api.resend.com/webhooks' => Http::response(['id' => 'whk_1'])]);

    Resend::webhooks()->create('https://example.com/hook');

    Http::assertSent(fn ($request) => $request['events'] === ['email.sent', 'email.delivered', 'email.bounced']);
});

it('creates a webhook with custom events', function () {
    Http::fake(['api.resend.com/webhooks' => Http::response(['id' => 'whk_1'])]);

    Resend::webhooks()->create('https://example.com/hook', ['email.complained']);

    Http::assertSent(fn ($request) => $request['events'] === ['email.complained']);
});

it('deletes a webhook', function () {
    Http::fake(['api.resend.com/webhooks/whk_1' => Http::response(['deleted' => true])]);

    expect(Resend::webhooks()->delete('whk_1')['deleted'])->toBeTrue();
});
