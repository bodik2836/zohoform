<?php

namespace App\Http\Controllers\Zoho;

use App\Http\Controllers\Controller;
use App\Http\Requests\Zoho\Account\StoreRequest;
use App\Services\Zoho\AccountService as ZohoAccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        protected ZohoAccountService $zohoAccountService,
    ) {
    }

    public function index(Request $request)
    {
        $accounts = $this->zohoAccountService->getAccounts();

        return view('accounts.index');
//        return redirect()->route('zoho.accounts');
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $this->zohoAccountService->storeAccount($data);

        return redirect()->back()->with('messages', [
            [
                'type' => 'success',
                'text' => 'Account successfully created.'
            ]
        ]);
    }
}
