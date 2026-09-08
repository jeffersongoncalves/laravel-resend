<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Exceptions\ResendException;
use JeffersonGoncalves\Resend\Facades\Resend;

it('sends the api key as a bearer token', function () {
    Http::fake(['api.resend.com/*' => Http::response(['data' => []])]);

    Resend::audiences()->list();

    Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'Bearer re_test_key'));
});

it('drops null query parameters', function () {
    Http::fake(['api.resend.com/*' => Http::response(['data' => []])]);

    Resend::emails()->list();

    Http::assertSent(fn ($request) => ! str_contains($request->url(), 'limit'));
});

it('throws a resend exception on a failed response', function () {
    Http::fake(['api.resend.com/*' => Http::response(['message' => 'API key is invalid', 'name' => 'validation_error'], 401)]);

    expect(fn () => Resend::audiences()->list())
        ->toThrow(ResendException::class, 'API key is invalid');
});

it('exposes the error body on the exception', function () {
    Http::fake(['api.resend.com/*' => Http::response(['message' => 'Nope', 'name' => 'restricted_api_key'], 403)]);

    try {
        Resend::audiences()->list();
    } catch (ResendException $exception) {
        expect($exception->errorBody()['name'])->toBe('restricted_api_key')
            ->and($exception->getCode())->toBe(403);
    }
});

it('falls back to a generic message when the body has none', function () {
    Http::fake(['api.resend.com/*' => Http::response([], 500)]);

    expect(fn () => Resend::audiences()->list())
        ->toThrow(ResendException::class, 'Resend API error (HTTP 500).');
});
