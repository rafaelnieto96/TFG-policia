<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Exception;

class AchievementService
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

    public function getAchievementsList()
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/achievements');
            $data = $response->toArray();

            return $data['hydra:member'];
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function getOneAchievement($id)
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/achievements/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function createAchievement($data)
    {
        try {
            $response = $this->httpClient->request('POST', $this->apiUrl . '/achievements', [
                'json' => $data,
            ]);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateAchievement($id, $data)
    {
        try {
            $response = $this->httpClient->request('PUT', $this->apiUrl . '/achievements/' . $id, [
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
            $response = $this->httpClient->request('DELETE', $this->apiUrl . '/achievements/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }
}
