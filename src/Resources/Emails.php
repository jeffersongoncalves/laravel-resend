<?php

namespace JeffersonGoncalves\Resend\Resources;

use JeffersonGoncalves\Resend\ResendClient;

class Emails
{
    public function __construct(
        protected ResendClient $client,
    ) {}

    /**
     * @param  array<string, mixed>  $payload  from, to, subject, html/text, cc, bcc, reply_to, tags, ...
     * @return array<string, mixed>
     */
    public function send(array $payload): array
    {
        return $this->client->post('/emails', $payload);
    }

    /**
     * Send up to 100 emails in a single call.
     *
     * @param  array<int, array<string, mixed>>  $emails
     * @return array<string, mixed>
     */
    public function batch(array $emails): array
    {
        return $this->client->post('/emails/batch', $emails);
    }

    /** @return array<string, mixed> */
    public function list(?int $limit = null): array
    {
        return $this->client->get('/emails', ['limit' => $limit]);
    }

    /** @return array<string, mixed> */
    public function get(string $emailId): array
    {
        return $this->client->get("/emails/{$emailId}");
    }

    /** @return array<string, mixed> */
    public function cancel(string $emailId): array
    {
        return $this->client->post("/emails/{$emailId}/cancel");
    }
}
