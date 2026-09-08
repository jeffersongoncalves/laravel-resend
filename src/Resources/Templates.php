<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Templates
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): array
    {
        return $this->client->get('/templates', [
            'limit' => $limit,
            'after' => $after,
            'before' => $before,
        ]);
    }

    /** @return array<string, mixed> */
    public function get(string $templateId): array
    {
        return $this->client->get("/templates/{$templateId}");
    }

    /**
     * @param  array<string, mixed>  $attributes  alias, from, subject, text, reply_to, variables
     * @return array<string, mixed>
     */
    public function create(string $name, string $html, array $attributes = []): array
    {
        return $this->client->post('/templates', array_merge($attributes, [
            'name' => $name,
            'html' => $html,
        ]));
    }

    /**
     * @param  array<string, mixed>  $attributes  name, html, alias, from, subject, text, reply_to, variables
     * @return array<string, mixed>
     */
    public function update(string $templateId, array $attributes): array
    {
        return $this->client->patch("/templates/{$templateId}", $attributes);
    }

    /** @return array<string, mixed> */
    public function delete(string $templateId): array
    {
        return $this->client->delete("/templates/{$templateId}");
    }

    /** @return array<string, mixed> */
    public function publish(string $templateId): array
    {
        return $this->client->post("/templates/{$templateId}/publish");
    }

    /** @return array<string, mixed> */
    public function duplicate(string $templateId): array
    {
        return $this->client->post("/templates/{$templateId}/duplicate");
    }
}
