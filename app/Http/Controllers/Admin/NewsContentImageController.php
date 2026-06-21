<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsContentImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class NewsContentImageController extends Controller
{
    public function __invoke(StoreNewsContentImageRequest $request): JsonResponse
    {
        $path = $request->file('image')->store('news/content', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
