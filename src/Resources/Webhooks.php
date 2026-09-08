<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Webhooks
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->client->get('/webhooks');
    }

    /** @return array<string, mixed> */
    public function get(string $webhookId): array
    {
        return $this->client->get("/webhooks/{$webhookId}");
    }

    /**
     * @param  array<int, string>  $events
     * @return array<string, mixed>
     */
    public function create(string $url, array $events = ['email.sent', 'email.delivered', 'email.bounced']): array
    {
        return $this->client->post('/webhooks', [
            'url' => $url,
            'events' => $events,
        ]);
    }

    /** @return array<string, mixed> */
    public function delete(string $webhookId): array
    {
        return $this->client->delete("/webhooks/{$webhookId}");
    }
}
