<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Broadcasts
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(?int $limit = null): array
    {
        return $this->client->get('/broadcasts', ['limit' => $limit]);
    }

    /** @return array<string, mixed> */
    public function get(string $broadcastId): array
    {
        return $this->client->get("/broadcasts/{$broadcastId}");
    }

    /**
     * @param  array<string, mixed>  $attributes  html, text, name, reply_to
     * @return array<string, mixed>
     */
    public function create(string $segmentId, string $from, string $subject, array $attributes = []): array
    {
        return $this->client->post('/broadcasts', array_merge($attributes, [
            'segment_id' => $segmentId,
            'from' => $from,
            'subject' => $subject,
        ]));
    }

    /** @return array<string, mixed> */
    public function send(string $broadcastId, ?string $scheduledAt = null): array
    {
        return $this->client->post("/broadcasts/{$broadcastId}/send", array_filter([
            'scheduled_at' => $scheduledAt,
        ], fn ($value) => $value !== null));
    }

    /** @return array<string, mixed> */
    public function delete(string $broadcastId): array
    {
        return $this->client->delete("/broadcasts/{$broadcastId}");
    }
}
