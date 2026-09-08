<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Contacts
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /** @return array<string, mixed> */
    public function list(string $audienceId, ?int $limit = null): array
    {
        return $this->client->get("/audiences/{$audienceId}/contacts", ['limit' => $limit]);
    }

    /** @return array<string, mixed> */
    public function get(string $audienceId, string $contactId): array
    {
        return $this->client->get("/audiences/{$audienceId}/contacts/{$contactId}");
    }

    /** @return array<string, mixed> */
    public function create(
        string $audienceId,
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?bool $unsubscribed = null,
    ): array {
        return $this->client->post("/audiences/{$audienceId}/contacts", array_filter([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'unsubscribed' => $unsubscribed,
        ], fn ($value) => $value !== null));
    }

    /** @return array<string, mixed> */
    public function update(
        string $audienceId,
        string $contactId,
        ?string $firstName = null,
        ?string $lastName = null,
        ?bool $unsubscribed = null,
    ): array {
        return $this->client->patch("/audiences/{$audienceId}/contacts/{$contactId}", array_filter([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'unsubscribed' => $unsubscribed,
        ], fn ($value) => $value !== null));
    }

    /** @return array<string, mixed> */
    public function delete(string $audienceId, string $contactId): array
    {
        return $this->client->delete("/audiences/{$audienceId}/contacts/{$contactId}");
    }
}
