<?php

namespace App\Http\Controllers;

use App\Services\ParcelService;
use App\Http\Requests\ParcelRequest;

class ParcelController extends Controller
{
    private ParcelService $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    public function create(ParcelRequest $request)
    {
        return $this->parcelService->create($request);
    }
}
