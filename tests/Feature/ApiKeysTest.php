<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists api keys', function () {
    Http::fake(['api.resend.com/api-keys' => Http::response(['data' => [['id' => 'key_1', 'name' => 'prod']]])]);

    expect(Resend::apiKeys()->list()['data'][0]['name'])->toBe('prod');
});

it('creates an api key scoped to a domain', function () {
    Http::fake(['api.resend.com/api-keys' => Http::response(['id' => 'key_1', 'token' => 're_123'])]);

    $result = Resend::apiKeys()->create('prod', 'sending_access', 'dom_1');

    expect($result['token'])->toBe('re_123');
    Http::assertSent(fn ($request) => $request['permission'] === 'sending_access' && $request['domain_id'] === 'dom_1');
});

it('deletes an api key', function () {
    Http::fake(['api.resend.com/api-keys/key_1' => Http::response([])]);

    Resend::apiKeys()->delete('key_1');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});
