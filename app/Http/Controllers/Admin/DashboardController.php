<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalPosts' => NewsPost::query()->count(),
            'publishedPosts' => NewsPost::query()->published()->count(),
            'draftPosts' => NewsPost::query()->where('is_published', false)->count(),
            'latestPosts' => NewsPost::query()->latest()->take(5)->get(),
        ]);
    }
}
