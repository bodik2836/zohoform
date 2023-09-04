<?php

namespace App\Http\Controllers\Zoho;

use App\Http\Controllers\Controller;
use App\Http\Requests\Zoho\Form\StoreRequest;
use App\Services\Zoho\AccountService as ZohoAccountService;
use App\Services\Zoho\DealService as ZohoDealService;

class FormController extends Controller
{
    public function __construct(
        protected ZohoAccountService $zohoAccountService,
        protected ZohoDealService $zohoDealService
    ) {}

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $accountResponse = $this->zohoAccountService->storeAccount($this->zohoAccountService->prepareAccountData($data));
        $accountData = json_decode($accountResponse, true);

        if (isset($accountData['data']) && $accountData['data'][0]['status'] == 'success') {
            $data['Account_Id'] = $accountData['data'][0]['details']['id'] ?? '';
        }

        $dealResponse = $this->zohoDealService->storeDeal($this->zohoDealService->prepareDealData($data));
        $dealData = json_decode($dealResponse, true);

        return response(array_merge($accountData['data'], $dealData['data']));
    }
}
