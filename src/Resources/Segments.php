<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Segments
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(?int $limit = null): array
    {
        return $this->client->get('/segments', ['limit' => $limit]);
    }

    /** @return array<string, mixed> */
    public function get(string $segmentId): array
    {
        return $this->client->get("/segments/{$segmentId}");
    }

    /** @return array<string, mixed> */
    public function create(string $name): array
    {
        return $this->client->post('/segments', ['name' => $name]);
    }

    /** @return array<string, mixed> */
    public function delete(string $segmentId): array
    {
        return $this->client->delete("/segments/{$segmentId}");
    }
}
