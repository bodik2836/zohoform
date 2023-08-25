<?php

namespace App\Http\Controllers\Zoho\Settings;

use App\Http\Controllers\Controller;
use App\Services\Zoho\DealService as ZohoDealService;

class DealStagesController extends Controller
{
    public function __construct(
        protected ZohoDealService $zohoDealService
    ) {}

    public function index()
    {
        return response($this->zohoDealService->getDealStages());
    }
}
