<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Domains
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(?int $limit = null): array
    {
        return $this->client->get('/domains', ['limit' => $limit]);
    }

    /** @return array<string, mixed> */
    public function get(string $domainId): array
    {
        return $this->client->get("/domains/{$domainId}");
    }

    /** @return array<string, mixed> */
    public function create(string $name, ?string $region = null): array
    {
        return $this->client->post('/domains', array_filter([
            'name' => $name,
            'region' => $region,
        ], fn ($value) => $value !== null));
    }

    /** @return array<string, mixed> */
    public function verify(string $domainId): array
    {
        return $this->client->post("/domains/{$domainId}/verify");
    }

    /** @return array<string, mixed> */
    public function delete(string $domainId): array
    {
        return $this->client->delete("/domains/{$domainId}");
    }
}
