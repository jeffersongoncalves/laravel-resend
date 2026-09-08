<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Audiences
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->client->get('/audiences');
    }

    /** @return array<string, mixed> */
    public function get(string $audienceId): array
    {
        return $this->client->get("/audiences/{$audienceId}");
    }

    /** @return array<string, mixed> */
    public function create(string $name): array
    {
        return $this->client->post('/audiences', ['name' => $name]);
    }

    /** @return array<string, mixed> */
    public function delete(string $audienceId): array
    {
        return $this->client->delete("/audiences/{$audienceId}");
    }
}
