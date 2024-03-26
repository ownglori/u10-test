<?php

namespace App\Http\Controllers;

use App\Services\ParcelService;
use App\Http\Requests\ParcelRequest;

class ParcelController extends Controller
{
    private ParcelService $orderService;

    public function __construct(ParcelService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(ParcelRequest $request)
    {
        return $this->orderService->create($request);
    }
}
