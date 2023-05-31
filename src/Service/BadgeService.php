<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Exception;

class BadgeService
{
    private $apiUrl;
    private $httpClient;

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = HttpClient::create([
            'verify_peer' => false,
            'verify_host' => false,
        ]);
    }

    public function getBadgesList()
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/badges');
            $data = $response->toArray();

            return $data['hydra:member'];
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function getOneBadge($id)
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/badges/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function createBadge($data)
    {
        try {
            $response = $this->httpClient->request('POST', $this->apiUrl . '/badges', [
                'json' => $data,
            ]);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateBadge($id, $data)
    {
        try {
            $response = $this->httpClient->request('PUT', $this->apiUrl . '/badges/' . $id, [
                'json' => $data,
            ]);
            $data = $response->toArray();
    
            return $data;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->httpClient->request('DELETE', $this->apiUrl . '/badges/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }
}
