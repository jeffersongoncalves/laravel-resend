<?php

namespace JeffersonGoncalves\Resend;

use JeffersonGoncalves\Resend\Resources\ApiKeys;
use JeffersonGoncalves\Resend\Resources\Audiences;
use JeffersonGoncalves\Resend\Resources\Broadcasts;
use JeffersonGoncalves\Resend\Resources\Contacts;
use JeffersonGoncalves\Resend\Resources\Domains;
use JeffersonGoncalves\Resend\Resources\Emails;
use JeffersonGoncalves\Resend\Resources\Segments;
use JeffersonGoncalves\Resend\Resources\Templates;
use JeffersonGoncalves\Resend\Resources\Webhooks;

/**
 * Entry point exposing one resource per Resend API group.
 */
class Resend
{
    protected ResendClient $client;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.resend.com')
    {
        $this->client = new ResendClient($apiKey, $baseUrl);
    }

    public function emails(): Emails
    {
        return new Emails($this->client);
    }

    public function domains(): Domains
    {
        return new Domains($this->client);
    }

    public function apiKeys(): ApiKeys
    {
        return new ApiKeys($this->client);
    }

    public function audiences(): Audiences
    {
        return new Audiences($this->client);
    }

    public function contacts(): Contacts
    {
        return new Contacts($this->client);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks($this->client);
    }

    public function templates(): Templates
    {
        return new Templates($this->client);
    }

    public function broadcasts(): Broadcasts
    {
        return new Broadcasts($this->client);
    }

    public function segments(): Segments
    {
        return new Segments($this->client);
    }
}
