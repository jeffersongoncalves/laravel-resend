<?php

namespace JeffersonGoncalves\Resend;

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Resend\Exceptions\ResendException;

/**
 * Thin wrapper around Laravel's Http client for the Resend API
 * (https://resend.com/docs/api-reference), authenticated with a Bearer token.
 */
class ResendClient
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://api.resend.com',
    ) {}

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request('get', $path, array_filter($query, fn ($value) => $value !== null));
    }

    /**
     * @param  array<mixed>|null  $body
     * @return array<string, mixed>
     */
    public function post(string $path, ?array $body = null): array
    {
        return $this->request('post', $path, $body);
    }

    /**
     * @param  array<string, mixed>|null  $body
     * @return array<string, mixed>
     */
    public function patch(string $path, ?array $body = null): array
    {
        return $this->request('patch', $path, $body);
    }

    /**
     * @return array<string, mixed>
     */
    public function delete(string $path): array
    {
        return $this->request('delete', $path);
    }

    /**
     * @param  array<mixed>|null  $data
     * @return array<string, mixed>
     */
    protected function request(string $method, string $path, ?array $data = null): array
    {
        $response = Http::withToken($this->apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->baseUrl($this->baseUrl)
            ->{$method}($path, $data ?? []);

        if ($response->failed()) {
            throw ResendException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
