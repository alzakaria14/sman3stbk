<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $latestPosts = NewsPost::query()
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', [
            'latestPosts' => $latestPosts,
        ]);
    }
}
