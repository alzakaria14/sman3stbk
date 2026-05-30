<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsPostRequest;
use App\Http\Requests\Admin\UpdateNewsPostRequest;
use App\Models\NewsPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsPostController extends Controller
{
    public function index(): View
    {
        $posts = NewsPost::query()
            ->latest()
            ->paginate(10);

        return view('admin.news.index', [
            'posts' => $posts,
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'post' => new NewsPost([
                'is_published' => true,
                'published_at' => now(),
            ]),
        ]);
    }

    public function store(StoreNewsPostRequest $request): RedirectResponse
    {
        $data = $this->validatedPostData($request);
        $data['user_id'] = $request->user()?->id;

        if ($request->hasFile('featured_image')) {
            $data['featured_image_path'] = $request->file('featured_image')->store('news', 'public');
        }

        $post = NewsPost::query()->create($data);

        return redirect()
            ->route('admin.news.edit', $post)
            ->with('status', 'Berita berhasil dibuat.');
    }

    public function show(NewsPost $news): RedirectResponse
    {
        return redirect()->route('admin.news.edit', $news);
    }

    public function edit(NewsPost $news): View
    {
        return view('admin.news.edit', [
            'post' => $news,
        ]);
    }

    public function update(UpdateNewsPostRequest $request, NewsPost $news): RedirectResponse
    {
        $data = $this->validatedPostData($request, $news);

        if ($request->boolean('remove_featured_image')) {
            $this->deletePublicFile($news->featured_image_path);
            $data['featured_image_path'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $this->deletePublicFile($news->featured_image_path);
            $data['featured_image_path'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()
            ->route('admin.news.edit', $news)
            ->with('status', 'Berita berhasil diperbarui.');
    }

    public function destroy(NewsPost $news): RedirectResponse
    {
        $this->deletePublicFile($news->featured_image_path);
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Berita berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedPostData(StoreNewsPostRequest|UpdateNewsPostRequest $request, ?NewsPost $post = null): array
    {
        $data = $request->safe()->except(['featured_image', 'remove_featured_image']);
        $data['is_published'] = $request->boolean('is_published');
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $post);
        $data['published_at'] = $data['is_published']
            ? ($data['published_at'] ?: now())
            : null;

        return $data;
    }

    private function uniqueSlug(string $value, ?NewsPost $post = null): string
    {
        $slug = Str::slug($value) ?: Str::random(8);
        $baseSlug = $slug;
        $counter = 2;

        while (NewsPost::query()
            ->where('slug', $slug)
            ->when($post, fn ($query) => $query->whereKeyNot($post->id))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
