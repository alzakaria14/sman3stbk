<?php

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can upload an image for news content', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $image = UploadedFile::fake()->image('kegiatan-sekolah.jpg', 1200, 800);

    $response = $this->actingAs($admin)
        ->postJson(route('admin.news.content-images.store'), [
            'image' => $image,
        ]);

    $response
        ->assertSuccessful()
        ->assertJsonStructure(['url']);

    expect(Storage::disk('public')->allFiles('news/content'))->toHaveCount(1);
});

test('news content image upload rejects non image files', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->postJson(route('admin.news.content-images.store'), [
            'image' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ])
        ->assertInvalid(['image']);

    Storage::disk('public')->assertDirectoryEmpty('news/content');
});

test('news rich text is sanitized before it is stored and rendered', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), [
            'title' => 'Berita dengan Format',
            'slug' => '',
            'content' => '<h2>Agenda</h2><p onclick="alert(1)">Baca <strong>selengkapnya</strong> <a href="javascript:alert(1)">di sini</a>.</p><script>alert(1)</script>',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d H:i:s'),
        ])
        ->assertRedirect();

    $post = NewsPost::query()->where('slug', 'berita-dengan-format')->firstOrFail();

    expect($post->content)
        ->toContain('<h2>Agenda</h2>')
        ->toContain('<strong>selengkapnya</strong>')
        ->not->toContain('onclick')
        ->not->toContain('javascript:')
        ->not->toContain('<script');

    $this->get(route('news.show', $post))
        ->assertSuccessful()
        ->assertSee('<h2>Agenda</h2>', false)
        ->assertDontSee('onclick', false)
        ->assertDontSee('javascript:', false);
});

test('news editor rejects visually empty quill content', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->from(route('admin.news.create'))
        ->post(route('admin.news.store'), [
            'title' => 'Berita Kosong',
            'slug' => '',
            'content' => '<p><br></p>',
            'is_published' => '0',
        ])
        ->assertRedirect(route('admin.news.create'))
        ->assertSessionHasErrors('content');
});

test('legacy plain text content remains plain text', function () {
    $post = NewsPost::factory()->create([
        'content' => 'Riset & Inovasi',
    ]);

    $post->refresh();

    expect($post->content)
        ->toBe('Riset & Inovasi')
        ->and($post->hasRichContent())
        ->toBeFalse();
});
