<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class ApiKeys
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->client->get('/api-keys');
    }

    /**
     * @param  string|null  $permission  full_access or sending_access
     * @return array<string, mixed>
     */
    public function create(string $name, ?string $permission = null, ?string $domainId = null): array
    {
        return $this->client->post('/api-keys', array_filter([
            'name' => $name,
            'permission' => $permission,
            'domain_id' => $domainId,
        ], fn ($value) => $value !== null));
    }

    /** @return array<string, mixed> */
    public function delete(string $apiKeyId): array
    {
        return $this->client->delete("/api-keys/{$apiKeyId}");
    }
}
