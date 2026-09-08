<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Facades\Resend;

it('lists templates with pagination', function () {
    Http::fake(['api.resend.com/templates*' => Http::response(['data' => [['id' => 'tpl_1']]])]);

    Resend::templates()->list(10, 'tpl_0');

    Http::assertSent(fn ($request) => $request['limit'] === 10
        && $request['after'] === 'tpl_0'
        && ! array_key_exists('before', $request->data()));
});

it('gets a template', function () {
    Http::fake(['api.resend.com/templates/tpl_1' => Http::response(['id' => 'tpl_1', 'name' => 'Welcome'])]);

    expect(Resend::templates()->get('tpl_1')['name'])->toBe('Welcome');
});

it('creates a template with extra attributes', function () {
    Http::fake(['api.resend.com/templates' => Http::response(['id' => 'tpl_1'])]);

    Resend::templates()->create('Welcome', '<p>Hi</p>', ['subject' => 'Welcome aboard']);

    Http::assertSent(fn ($request) => $request['name'] === 'Welcome'
        && $request['html'] === '<p>Hi</p>'
        && $request['subject'] === 'Welcome aboard');
});

it('updates a template', function () {
    Http::fake(['api.resend.com/templates/tpl_1' => Http::response(['id' => 'tpl_1'])]);

    Resend::templates()->update('tpl_1', ['subject' => 'New subject']);

    Http::assertSent(fn ($request) => $request->method() === 'PATCH' && $request['subject'] === 'New subject');
});

it('publishes and duplicates a template', function () {
    Http::fake([
        'api.resend.com/templates/tpl_1/publish' => Http::response(['id' => 'tpl_1', 'status' => 'published']),
        'api.resend.com/templates/tpl_1/duplicate' => Http::response(['id' => 'tpl_2']),
    ]);

    expect(Resend::templates()->publish('tpl_1')['status'])->toBe('published')
        ->and(Resend::templates()->duplicate('tpl_1')['id'])->toBe('tpl_2');
});

it('deletes a template', function () {
    Http::fake(['api.resend.com/templates/tpl_1' => Http::response(['deleted' => true])]);

    expect(Resend::templates()->delete('tpl_1')['deleted'])->toBeTrue();
});
