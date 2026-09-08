<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('sends an email', function () {
    Http::fake(['api.resend.com/emails' => Http::response(['id' => 'email_1'])]);

    $result = Resend::emails()->send([
        'from' => 'me@example.com',
        'to' => ['you@example.com'],
        'subject' => 'Hello',
        'html' => '<p>Hi</p>',
    ]);

    expect($result['id'])->toBe('email_1');
    Http::assertSent(fn ($request) => $request['subject'] === 'Hello');
});

it('sends a batch of emails', function () {
    Http::fake(['api.resend.com/emails/batch' => Http::response(['data' => [['id' => 'email_1'], ['id' => 'email_2']]])]);

    $result = Resend::emails()->batch([
        ['from' => 'me@example.com', 'to' => ['a@example.com'], 'subject' => 'A'],
        ['from' => 'me@example.com', 'to' => ['b@example.com'], 'subject' => 'B'],
    ]);

    expect($result['data'])->toHaveCount(2);
});

it('lists emails', function () {
    Http::fake(['api.resend.com/emails*' => Http::response(['data' => [['id' => 'email_1']]])]);

    $result = Resend::emails()->list(10);

    expect($result['data'][0]['id'])->toBe('email_1');
    Http::assertSent(fn ($request) => $request['limit'] === 10);
});

it('gets an email', function () {
    Http::fake(['api.resend.com/emails/email_1' => Http::response(['id' => 'email_1', 'subject' => 'Hello'])]);

    expect(Resend::emails()->get('email_1')['subject'])->toBe('Hello');
});

it('cancels a scheduled email', function () {
    Http::fake(['api.resend.com/emails/email_1/cancel' => Http::response(['id' => 'email_1'])]);

    expect(Resend::emails()->cancel('email_1')['id'])->toBe('email_1');
    Http::assertSent(fn ($request) => $request->method() === 'POST');
});
