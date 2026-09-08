<div class="filament-hidden">

![Laravel Resend](https://raw.githubusercontent.com/jeffersongoncalves/laravel-resend/main/art/jeffersongoncalves-laravel-resend.png)

</div>

# Laravel Resend

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-resend.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-resend)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-resend/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-resend/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-resend/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-resend/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-resend.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-resend)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-resend.svg?style=flat-square)](LICENSE.md)

A Laravel wrapper for the [Resend API](https://resend.com/docs/api-reference). Covers emails, domains, API keys, audiences, contacts, webhooks, templates, broadcasts and segments through a simple, typed API built on Laravel's `Http` client.

## Features

- Emails: `send`, `batch`, `list`, `get`, `cancel`
- Domains: `list`, `get`, `create`, `verify`, `delete`
- API keys: `list`, `create`, `delete`
- Audiences: `list`, `get`, `create`, `delete`
- Contacts: `list`, `get`, `create`, `update`, `delete`
- Webhooks: `list`, `get`, `create`, `delete`
- Templates: `list`, `get`, `create`, `update`, `delete`, `publish`, `duplicate`
- Broadcasts: `list`, `get`, `create`, `send`, `delete`
- Segments: `list`, `get`, `create`, `delete`
- Throws `ResendException` (with the original API error body) on any non-2xx response

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-resend
```

Publish the config file:

```bash
php artisan vendor:publish --tag=resend-config
```

Set your Resend API key in `.env`:

```env
RESEND_API_KEY=re_your_api_key
```

Create (or find) your API key at [resend.com/api-keys](https://resend.com/api-keys).

## Configuration

```php
// config/resend.php
return [
    'api_key' => env('RESEND_API_KEY', ''),
    'base_url' => env('RESEND_BASE_URL', 'https://api.resend.com'),
];
```

## Usage

The package is resolved via the `Resend` facade or by injecting `JeffersonGoncalves\Resend\Resend`. Each resource is exposed as a method returning a dedicated resource class.

### Emails

```php
use JeffersonGoncalves\Resend\Facades\Resend;

Resend::emails()->send([
    'from' => 'Acme <hello@example.com>',
    'to' => ['jane@example.com'],
    'subject' => 'Hello!',
    'html' => '<p>Welcome aboard.</p>',
]);

Resend::emails()->batch([
    ['from' => 'hello@example.com', 'to' => ['a@example.com'], 'subject' => 'A', 'html' => '<p>A</p>'],
    ['from' => 'hello@example.com', 'to' => ['b@example.com'], 'subject' => 'B', 'html' => '<p>B</p>'],
]);

$emails = Resend::emails()->list(limit: 10);

$email = Resend::emails()->get('email_id');

Resend::emails()->cancel('email_id');
```

### Domains

```php
$domains = Resend::domains()->list(limit: 10);

$domain = Resend::domains()->get('domain_id');

Resend::domains()->create('example.com', region: 'us-east-1');

Resend::domains()->verify('domain_id');

Resend::domains()->delete('domain_id');
```

### API keys

```php
$keys = Resend::apiKeys()->list();

Resend::apiKeys()->create('production', permission: 'sending_access', domainId: 'domain_id');

Resend::apiKeys()->delete('api_key_id');
```

### Audiences and contacts

```php
$audiences = Resend::audiences()->list();

Resend::audiences()->create('Newsletter');

Resend::contacts()->create(
    audienceId: 'audience_id',
    email: 'jane@example.com',
    firstName: 'Jane',
    lastName: 'Doe',
);

Resend::contacts()->update(
    audienceId: 'audience_id',
    contactId: 'contact_id',
    unsubscribed: true,
);

Resend::contacts()->delete('audience_id', 'contact_id');
```

### Webhooks

```php
Resend::webhooks()->create('https://example.com/webhooks/resend', [
    'email.sent',
    'email.delivered',
    'email.bounced',
]);

$webhooks = Resend::webhooks()->list();

Resend::webhooks()->delete('webhook_id');
```

### Templates

```php
Resend::templates()->create('Welcome', '<p>Hi {{name}}</p>', [
    'subject' => 'Welcome aboard',
    'from' => 'hello@example.com',
]);

Resend::templates()->update('template_id', ['subject' => 'New subject']);

Resend::templates()->publish('template_id');

Resend::templates()->duplicate('template_id');
```

### Broadcasts and segments

```php
Resend::segments()->create('Active subscribers');

$broadcast = Resend::broadcasts()->create(
    segmentId: 'segment_id',
    from: 'hello@example.com',
    subject: 'Release notes',
    attributes: ['html' => '<p>What is new.</p>'],
);

Resend::broadcasts()->send($broadcast['id'], scheduledAt: '2026-01-01T10:00:00Z');
```

### Error handling

Any non-2xx API response throws `JeffersonGoncalves\Resend\Exceptions\ResendException`, which exposes the decoded error body:

```php
use JeffersonGoncalves\Resend\Exceptions\ResendException;

try {
    Resend::emails()->send($payload);
} catch (ResendException $e) {
    logger()->error($e->getMessage(), $e->errorBody());
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
