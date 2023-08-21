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
    ) {
    }

    public function getAccounts()
    {
        $accessToken = $this->zohoAuthService->getToken('zoho_access_token');

        if (!$accessToken) {
            $this->zohoAuthService->refreshToken();
        }

        $response = null;

        try {
            $response = $this->httpClient->request('GET', "https://www.zohoapis.eu/crm/v2/Accounts", [
                'headers' => [
                    'Authorization' => "Zoho-oauthtoken $accessToken",
                ],
            ]);
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401) {
                $this->zohoAuthService->refreshToken();
                Redirect::refresh()->send();
            }
        }

        return json_decode($response?->getBody()?->getContents(), true);
    }

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

        $responseData = $this->zohoAuthService->makeRequest('POST', $uri, $options);

        return $responseData['data'][0];
    }
}
