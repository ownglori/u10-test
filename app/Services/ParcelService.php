<?php

namespace App\Services;

use App\Http\Requests\ParcelRequest;

class ParcelService extends Service
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create(ParcelRequest $request)
    {
        $validated = $request->validated();

        $postService = $this->postService->get($validated['post_service']);

        if (!$postService) {
            return response()->json(['ok' => false, 'message' => 'Post service not found']);
        }

        return $postService->create($validated);
    }
}
