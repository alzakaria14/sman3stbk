<?php

use App\Models\NewsPost;
use App\Models\SchoolSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public website renders profile and published news', function () {
    SchoolSetting::factory()->create([
        'school_name' => 'SMA Nusantara',
        'site_name' => 'SMA Nusantara',
        'tagline' => 'Informasi sekolah terpercaya.',
        'establishment_decree' => '188.44/0791/KUM/2019',
        'employee_data' => 'Guru Satu - Guru Matematika',
    ]);

    $publishedPost = NewsPost::factory()->create([
        'title' => 'Agenda Literasi Sekolah',
        'slug' => 'agenda-literasi-sekolah',
        'published_at' => now(),
    ]);

    NewsPost::factory()->draft()->create([
        'title' => 'Catatan Internal',
        'slug' => 'catatan-internal',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('SMA Nusantara')
        ->assertSee($publishedPost->title)
        ->assertDontSee('Catatan Internal');

    $this->get(route('profile'))
        ->assertSuccessful()
        ->assertSee('SMA Nusantara')
        ->assertSee('188.44/0791/KUM/2019')
        ->assertSee('Guru Satu');

    $this->get(route('news.index'))
        ->assertSuccessful()
        ->assertSee($publishedPost->title)
        ->assertDontSee('Catatan Internal');

    $this->get(route('news.show', $publishedPost))
        ->assertSuccessful()
        ->assertSee($publishedPost->title);

    $this->get(route('news.show', 'catatan-internal'))
        ->assertNotFound();
});
