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

        if (isset($responseData['access_token'])) {
            $responseData = $this->zohoAuthService->makeRequest('GET', $uri);
        }

        return $responseData['stages'] ?? [];
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
        $data = $responseData['data'][0] ?? [];

        if (isset($data['status']) && $data['status'] == 'success') $data['successMessage'] = 'Deal successfully created.';
        if (isset($data['status']) && $data['status'] == 'error') $data['errorMessage'] = 'Deal was not created.';
        if (empty($data)) {
            $data['status'] = 'error';
            $data['errorMessage'] = 'Something went wrong with deal creation.';
        }
        return $data;
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
