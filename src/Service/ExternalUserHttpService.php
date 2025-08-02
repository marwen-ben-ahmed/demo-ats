<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

/**
 * Service to interact with an external user management API.
 */
class ExternalUserHttpService
{
    public function __construct(private HttpClientInterface $httpClient, private string $baseUrl) {}

    /**
     * Fetch a user from the external API.
     */
    public function getUser(int $id): array
    {
        try {
            $response = $this->httpClient->request('GET', "{$this->baseUrl}/{$id}");
            return $response->toArray();
        } catch (TransportExceptionInterface|ClientExceptionInterface|ServerExceptionInterface $e) {
            throw new \RuntimeException('External API error: ' . $e->getMessage());
        }
    }

    /**
     * Create a user via the external API.
     */
    public function createUser(array $data): array
    {
        try {
            $response = $this->httpClient->request('POST', $this->baseUrl, [
                'json' => $data,
            ]);
            return $response->toArray();
        } catch (TransportExceptionInterface|ClientExceptionInterface|ServerExceptionInterface $e) {
            throw new \RuntimeException('External API error: ' . $e->getMessage());
        }
    }

    /**
     * Update a user via the external API.
     */
    public function updateUser(int $id, array $data): array
    {
        try {
            $response = $this->httpClient->request('PUT', "{$this->baseUrl}/{$id}", [
                'json' => $data,
            ]);
            return $response->toArray();
        } catch (TransportExceptionInterface|ClientExceptionInterface|ServerExceptionInterface $e) {
            throw new \RuntimeException('External API error: ' . $e->getMessage());
        }
    }

    /**
     * Delete a user via the external API.
     */
    public function deleteUser(int $id): bool
    {
        try {
            $this->httpClient->request('DELETE', "{$this->baseUrl}/{$id}");
            return true;
        } catch (TransportExceptionInterface|ClientExceptionInterface|ServerExceptionInterface $e) {
            throw new \RuntimeException('External API error: ' . $e->getMessage());
        }
    }
}
