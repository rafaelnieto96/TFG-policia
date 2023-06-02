<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Exception;

class NotificationService
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

    public function getNotificationsList()
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '/notifications');
            $data = $response->toArray();

            return $data['hydra:member'];
        } catch (\Exception $exception) {
            // throw new Exception($exception->getMessage());
        }
    }
    
}
