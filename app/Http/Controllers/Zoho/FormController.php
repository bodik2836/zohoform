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
    ) {
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $account = $this->zohoAccountService->storeAccount($this->zohoAccountService->prepareAccountData($data));

        if (isset($account['status']) && $account['status'] == 'error') {
            $account = $this->zohoAccountService->storeAccount($this->zohoAccountService->prepareAccountData($data));
        }

        if (isset($account['status']) && $account['status'] == 'invalid_token') {

        }

        $data['Account_Id'] = $account['details']['id'] ?? '';
        $deal = $this->zohoDealService->storeDeal($this->zohoDealService->prepareDealData($data));

        return response([$account, $deal], 200);
    }
}
