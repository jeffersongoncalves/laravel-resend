<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists audiences', function () {
    Http::fake(['api.resend.com/audiences' => Http::response(['data' => [['id' => 'aud_1', 'name' => 'Newsletter']]])]);

    expect(Resend::audiences()->list()['data'][0]['name'])->toBe('Newsletter');
});

it('gets an audience', function () {
    Http::fake(['api.resend.com/audiences/aud_1' => Http::response(['id' => 'aud_1', 'name' => 'Newsletter'])]);

    expect(Resend::audiences()->get('aud_1')['name'])->toBe('Newsletter');
});

it('creates an audience', function () {
    Http::fake(['api.resend.com/audiences' => Http::response(['id' => 'aud_1'])]);

    Resend::audiences()->create('Newsletter');

    Http::assertSent(fn ($request) => $request['name'] === 'Newsletter');
});

it('deletes an audience', function () {
    Http::fake(['api.resend.com/audiences/aud_1' => Http::response(['deleted' => true])]);

    expect(Resend::audiences()->delete('aud_1')['deleted'])->toBeTrue();
});
