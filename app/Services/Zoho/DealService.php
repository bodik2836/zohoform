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

    public function getDealStages()
    {
        $uri = 'https://www.zohoapis.eu/crm/v2/settings/stages?module=Deals';

        $response = $this->zohoAuthService->makeRequest('GET', $uri);
        $responseData = json_decode($response->content(), true);

        if (isset($responseData['access_token'])) {
            $response = $this->zohoAuthService->makeRequest('GET', $uri);
        }

        return $response->content();
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

        $response = $this->zohoAuthService->makeRequest('POST', $uri, $options);
        $responseData = json_decode($response->content(), true);

        if (isset($responseData['data']) && $responseData['data'][0]['status'] == 'error') {
            $responseData['data'][0]['message'] = 'Deal was not created.';
        }

        if (isset($responseData['data']) && $responseData['data'][0]['status'] == 'success') {
            $responseData['data'][0]['message'] = 'Deal successfully created.';
        }

        $response->setContent($responseData);

        return $response->content();
    }

    public function prepareDealData($data): array
    {
        return [
            'Deal_Name' => $data['Deal_Name'] ?? '',
            'Stage' => $data['Stage'] ?? '',
            'Closing_Date' => $data['Closing_Date'] ?? '',
            'Account_Name' => [
                'id' => $data['Account_Id'] ?? '',
                'name' => $data['Account_Name'] ?? ''
            ],
        ];
    }
}
