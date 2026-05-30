<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $posts = NewsPost::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('news.index', [
            'posts' => $posts,
        ]);
    }

    public function show(NewsPost $newsPost): View
    {
        abort_unless($newsPost->isPublished(), 404);

        $relatedPosts = NewsPost::query()
            ->published()
            ->whereKeyNot($newsPost->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', [
            'post' => $newsPost,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
