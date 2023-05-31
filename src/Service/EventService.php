<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Exception;

class EventService
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

    public function getEventsList()
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/events');
            $data = $response->toArray();

            return $data['hydra:member'];
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function getOneEvent($id)
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/events/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }

    public function createEvent($data)
    {
        try {
            $response = $this->httpClient->request('POST', $this->apiUrl . '/events', [
                'json' => $data,
            ]);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateEvent($id, $data)
    {
        try {
            $response = $this->httpClient->request('PUT', $this->apiUrl . '/events/' . $id, [
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
            $response = $this->httpClient->request('DELETE', $this->apiUrl . '/events/' . $id);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }
}
