<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists contacts of an audience', function () {
    Http::fake(['api.resend.com/audiences/aud_1/contacts*' => Http::response(['data' => [['id' => 'con_1']]])]);

    expect(Resend::contacts()->list('aud_1', 20)['data'][0]['id'])->toBe('con_1');
    Http::assertSent(fn ($request) => $request['limit'] === 20);
});

it('gets a contact', function () {
    Http::fake(['api.resend.com/audiences/aud_1/contacts/con_1' => Http::response(['id' => 'con_1', 'email' => 'a@example.com'])]);

    expect(Resend::contacts()->get('aud_1', 'con_1')['email'])->toBe('a@example.com');
});

it('creates a contact', function () {
    Http::fake(['api.resend.com/audiences/aud_1/contacts' => Http::response(['id' => 'con_1'])]);

    Resend::contacts()->create('aud_1', 'a@example.com', 'Ada', 'Lovelace', false);

    Http::assertSent(fn ($request) => $request['email'] === 'a@example.com'
        && $request['first_name'] === 'Ada'
        && $request['unsubscribed'] === false);
});

it('updates a contact', function () {
    Http::fake(['api.resend.com/audiences/aud_1/contacts/con_1' => Http::response(['id' => 'con_1'])]);

    Resend::contacts()->update('aud_1', 'con_1', unsubscribed: true);

    Http::assertSent(fn ($request) => $request->method() === 'PATCH'
        && $request['unsubscribed'] === true
        && ! array_key_exists('first_name', $request->data()));
});

it('deletes a contact', function () {
    Http::fake(['api.resend.com/audiences/aud_1/contacts/con_1' => Http::response(['deleted' => true])]);

    expect(Resend::contacts()->delete('aud_1', 'con_1')['deleted'])->toBeTrue();
});
