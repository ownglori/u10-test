<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class UkrPostService extends Service
{
    public function create($validated): JsonResponse
    {
        // create parcel API UkrPost

        return response()->json(['ok' => true, 'data' => $validated]);
    }
}
