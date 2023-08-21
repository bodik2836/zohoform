<?php

namespace App\Services\Zoho;

use GuzzleHttp\Client;
use App\Services\Zoho\AuthService as ZohoAuthService;

class DealService
{
    public function __construct(
        protected Client $httpClient,
        protected ZohoAuthService $zohoAuthService
    ) {}

    public function getDealStages(): array
    {
        $uri = 'https://www.zohoapis.eu/crm/v2/settings/stages?module=Deals';

        $responseData = $this->zohoAuthService->makeRequest('GET', $uri);

        return $responseData['stages'];
    }

    public function storeDeal($data)
    {
        $uri = 'https://www.zohoapis.eu/crm/v2/Deals';
        $options = [
            'json' => [
                'data' => [
                    $data
                ],
            ]
        ];

        $responseData = $this->zohoAuthService->makeRequest('POST', $uri, $options);

        return $responseData['data'][0];
    }
}
