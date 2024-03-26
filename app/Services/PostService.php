<?php

namespace App\Services;

class PostService extends Service
{
    private array $postServices;

    public function __construct(NovaPostService $novaPostService, UkrPostService $ukrPostService)
    {
        $this->postServices = [
            'novapost' => $novaPostService,
            'ukrpost' => $ukrPostService,
        ];
    }

    public function get($service)
    {
        return $this->postServices[$service] ?? null;
    }
}
