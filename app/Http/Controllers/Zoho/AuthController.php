<?php

namespace App\Http\Controllers\Zoho;

use App\Http\Controllers\Controller;
use App\Services\Zoho\AuthService as ZohoAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected ZohoAuthService $zohoAuthService,
    ) {
    }

    public function home(Request $request)
    {
        return view('welcome');
    }

    public function auth()
    {
        return redirect($this->zohoAuthService->getAuthUri());
    }

    public function oauthredirect(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('home');
        }

        $code = $request->get('code');
        $this->zohoAuthService->generateTokens($code);

        return redirect()->route('home');
    }
}
