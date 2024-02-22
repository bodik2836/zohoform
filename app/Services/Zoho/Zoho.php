<?php

namespace App\Services\Zoho;

abstract class Zoho
{
    const OAUTH_URI = "https://accounts.zoho.eu/oauth/v2";
    const ZOHO_API_URI = "https://www.zohoapis.eu/crm/v2";

    private string $clientId = "";
    private string $clientSecret = "";

    public function __construct() {
        $this->clientId = config("app.zoho.client_id");
        $this->clientSecret = config("app.zoho.client_secret");
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
