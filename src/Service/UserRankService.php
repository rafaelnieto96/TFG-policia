<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Exception;

class UserRankService
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

    public function getRanksList()
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/user_ranks');
            $data = $response->toArray();

            return $data['hydra:member'];
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function getOneRank($id)
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/user_ranks/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function createRank($data)
    {
        try {
            $response = $this->httpClient->request('POST', $this->apiUrl . '/user_ranks', [
                'json' => $data,
            ]);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateRank($id, $data)
    {
        try {
            $response = $this->httpClient->request('PUT', $this->apiUrl . '/user_ranks/' . $id, [
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
            $response = $this->httpClient->request('DELETE', $this->apiUrl . '/user_ranks/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }
}
