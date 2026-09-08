<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists broadcasts', function () {
    Http::fake(['api.resend.com/broadcasts*' => Http::response(['data' => [['id' => 'bro_1']]])]);

    expect(Resend::broadcasts()->list(5)['data'][0]['id'])->toBe('bro_1');
});

it('gets a broadcast', function () {
    Http::fake(['api.resend.com/broadcasts/bro_1' => Http::response(['id' => 'bro_1', 'status' => 'draft'])]);

    expect(Resend::broadcasts()->get('bro_1')['status'])->toBe('draft');
});

it('creates a broadcast', function () {
    Http::fake(['api.resend.com/broadcasts' => Http::response(['id' => 'bro_1'])]);

    Resend::broadcasts()->create('seg_1', 'me@example.com', 'Release notes', ['html' => '<p>Hi</p>']);

    Http::assertSent(fn ($request) => $request['segment_id'] === 'seg_1'
        && $request['from'] === 'me@example.com'
        && $request['html'] === '<p>Hi</p>');
});

it('schedules a broadcast', function () {
    Http::fake(['api.resend.com/broadcasts/bro_1/send' => Http::response(['id' => 'bro_1'])]);

    Resend::broadcasts()->send('bro_1', '2026-01-01T10:00:00Z');

    Http::assertSent(fn ($request) => $request['scheduled_at'] === '2026-01-01T10:00:00Z');
});

it('sends a broadcast immediately', function () {
    Http::fake(['api.resend.com/broadcasts/bro_1/send' => Http::response(['id' => 'bro_1'])]);

    Resend::broadcasts()->send('bro_1');

    Http::assertSent(fn ($request) => ! array_key_exists('scheduled_at', $request->data()));
});

it('deletes a broadcast', function () {
    Http::fake(['api.resend.com/broadcasts/bro_1' => Http::response(['deleted' => true])]);

    expect(Resend::broadcasts()->delete('bro_1')['deleted'])->toBeTrue();
});
