<?php

namespace App\Services\Zoho;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redirect;

class AccountService
{
    public function __construct(
        protected Client $httpClient,
        protected AuthService $zohoAuthService
    ) {}

    public function storeAccount($data)
    {
        $uri = 'https://www.zohoapis.eu/crm/v2/Accounts';
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
            $responseData['data'][0]['message'] = 'Account was not created.';
        }

        if (isset($responseData['data']) && $responseData['data'][0]['status'] == 'success') {
            $responseData['data'][0]['message'] = 'Account successfully created.';
        }

        $response->setContent($responseData);

        return $response->content();
    }

    public function prepareAccountData($data): array
    {
        return [
            'Account_Name' => $data['Account_Name'] ?? '',
            'Phone' => $data['Phone'] ?? '',
            'Website' => $data['Website'] ?? '',
        ];
    }
}
