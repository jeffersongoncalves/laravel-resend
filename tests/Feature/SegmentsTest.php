<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists segments', function () {
    Http::fake(['api.resend.com/segments*' => Http::response(['data' => [['id' => 'seg_1', 'name' => 'Active']]])]);

    expect(Resend::segments()->list(5)['data'][0]['name'])->toBe('Active');
});

it('gets a segment', function () {
    Http::fake(['api.resend.com/segments/seg_1' => Http::response(['id' => 'seg_1', 'name' => 'Active'])]);

    expect(Resend::segments()->get('seg_1')['name'])->toBe('Active');
});

it('creates a segment', function () {
    Http::fake(['api.resend.com/segments' => Http::response(['id' => 'seg_1'])]);

    Resend::segments()->create('Active');

    Http::assertSent(fn ($request) => $request['name'] === 'Active');
});

it('deletes a segment', function () {
    Http::fake(['api.resend.com/segments/seg_1' => Http::response(['deleted' => true])]);

    expect(Resend::segments()->delete('seg_1')['deleted'])->toBeTrue();
});
