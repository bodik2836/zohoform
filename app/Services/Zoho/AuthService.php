<?php

namespace App\Services\Zoho;

use App\Models\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthService
{
    protected string $zohoOauthUri = 'https://accounts.zoho.eu/oauth/v2';
    protected string $zohoClientId = '';
    protected string $zohoClientSecret = '';

    protected string $redirectUri = '';

    public function __construct(
        protected Client $httpClient,
        protected Request $request
    ) {
        $this->zohoClientId = env('ZOHO_CLIENT_ID');
        $this->zohoClientSecret = env('ZOHO_CLIENT_SECRET');
        $this->redirectUri = env('APP_URL') . '/oauthredirect/';
    }

    public function makeRequest(string $method, string $uri, array $options = [])
    {
        $accessToken = $this->getToken('zoho_access_token');

        $options['headers'] = [
            'Authorization' => "Zoho-oauthtoken $accessToken",
        ];

        if (!$accessToken) {
            return $this->refreshToken();
        }

        $response = null;
        try {
            $response = $this->httpClient->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401) {
                return $this->refreshToken();
            }
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getAuthUri(): string
    {
        $authUri = "$this->zohoOauthUri/auth?";
        $authUri .= "client_id=$this->zohoClientId&";
        $authUri .= "response_type=code&";
        $authUri .= "redirect_uri=$this->redirectUri&";
        $authUri .= "scope=ZohoCRM.modules.accounts.ALL,ZohoCRM.modules.deals.ALL,ZohoCRM.settings.ALL&";
        $authUri .= "access_type=offline";

        return $authUri;
    }

    public function generateTokens($code = null): void
    {
        $response = null;
        try {
            $response = $this->httpClient->request('POST', "$this->zohoOauthUri/token", [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'client_id' => $this->zohoClientId,
                    'redirect_uri' => $this->redirectUri,
                    'client_secret' => $this->zohoClientSecret,
                ],
            ]);
        } catch (GuzzleException $e) {
            if ($e->getCode() != 200) Redirect::route('zoho.auth')->send();
        }

        $tokens = json_decode($response->getBody()->getContents(), true);

        $this->setToken('zoho_access_token', $tokens['access_token']);
        $this->setToken('zoho_refresh_token', $tokens['refresh_token']);
    }

    public function refreshToken()
    {
        $response = $this->makeRefreshTokenRequest();

        $responseData = json_decode($response->getBody()->getContents(), true);

        if (isset($responseData['error'])) return $responseData;

        $this->setToken('zoho_access_token', $responseData['access_token']);

        return $responseData;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeRefreshTokenRequest()
    {
        $refreshToken = $this->getToken('zoho_refresh_token');

        if (!$refreshToken) {
            Redirect::route('zoho.auth')->send();
        }

        return $this->httpClient->request('POST', "$this->zohoOauthUri/token", [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'form_params' => [
                'refresh_token' => $refreshToken,
                'client_id' => $this->zohoClientId,
                'grant_type' => 'refresh_token',
                'client_secret' => $this->zohoClientSecret,
            ],
        ]);
    }

    public function getToken(string $tokenName): ?string
    {
        $tokenModel = Token::query()->where('key', $tokenName)->first();

        return $tokenModel?->value;
    }

    public function setToken(string $key, string $value): void
    {
        Token::query()->updateOrCreate(
            [
                'key' => $key
            ],
            [
                'value' => $value
            ]
        );
    }
}
