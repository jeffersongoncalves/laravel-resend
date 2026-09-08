<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists domains', function () {
    Http::fake(['api.resend.com/domains*' => Http::response(['data' => [['id' => 'dom_1', 'name' => 'example.com']]])]);

    expect(Resend::domains()->list(5)['data'][0]['name'])->toBe('example.com');
    Http::assertSent(fn ($request) => $request['limit'] === 5);
});

it('gets a domain', function () {
    Http::fake(['api.resend.com/domains/dom_1' => Http::response(['id' => 'dom_1', 'status' => 'verified'])]);

    expect(Resend::domains()->get('dom_1')['status'])->toBe('verified');
});

it('creates a domain with a region', function () {
    Http::fake(['api.resend.com/domains' => Http::response(['id' => 'dom_1'])]);

    Resend::domains()->create('example.com', 'us-east-1');

    Http::assertSent(fn ($request) => $request['name'] === 'example.com' && $request['region'] === 'us-east-1');
});

it('omits the region when not given', function () {
    Http::fake(['api.resend.com/domains' => Http::response(['id' => 'dom_1'])]);

    Resend::domains()->create('example.com');

    Http::assertSent(fn ($request) => ! array_key_exists('region', $request->data()));
});

it('verifies a domain', function () {
    Http::fake(['api.resend.com/domains/dom_1/verify' => Http::response(['id' => 'dom_1'])]);

    expect(Resend::domains()->verify('dom_1')['id'])->toBe('dom_1');
});

it('deletes a domain', function () {
    Http::fake(['api.resend.com/domains/dom_1' => Http::response(['deleted' => true])]);

    expect(Resend::domains()->delete('dom_1')['deleted'])->toBeTrue();
    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});
