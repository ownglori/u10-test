<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class NovaPostService extends Service
{
    public function create($validated): JsonResponse
    {
        // create parcel API NovaPost

        return response()->json(['ok' => true, 'data' => $validated]);
    }
}
