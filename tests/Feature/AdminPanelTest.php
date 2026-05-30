<?php

use App\Models\NewsPost;
use App\Models\SchoolSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dashboard requires authentication', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('admin can authenticate', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@example.com',
    ]);

    $this->post(route('admin.login.store'), [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);
});

test('admin can update school identity and create news', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->put(route('admin.settings.update'), [
            'school_name' => 'SMA Admin',
            'site_name' => 'Portal SMA Admin',
            'tagline' => 'Portal informasi resmi.',
            'npsn' => '12345678',
            'accreditation' => 'A',
            'principal_name' => 'Ibu Kepala Sekolah',
            'established_year' => 2001,
            'establishment_decree' => 'SK-001',
            'operational_permit' => 'OP-001',
            'school_schedule' => 'Sehari Penuh/5 hari',
            'coordinates' => '-3.336065, 114.797672',
            'address' => 'Jl. Sekolah No. 1',
            'phone' => '0210000',
            'email' => 'info@example.com',
            'about' => 'Profil singkat sekolah.',
            'vision' => 'Unggul dan berkarakter.',
            'mission' => "Belajar bermutu\nLayanan terbuka",
            'employee_data' => 'Guru Admin - Guru',
        ])
        ->assertRedirect(route('admin.settings.edit'));

    expect(SchoolSetting::query()->first()->school_name)->toBe('SMA Admin')
        ->and(SchoolSetting::query()->first()->site_name)->toBe('Portal SMA Admin');

    $this->actingAs($admin)
        ->post(route('admin.news.store'), [
            'title' => 'Berita Baru Sekolah',
            'slug' => '',
            'excerpt' => 'Ringkasan berita sekolah.',
            'content' => 'Isi lengkap berita sekolah.',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d H:i:s'),
        ])
        ->assertRedirect();

    $post = NewsPost::query()->where('slug', 'berita-baru-sekolah')->first();

    expect($post)->not->toBeNull()
        ->and($post->isPublished())->toBeTrue();

    $this->get(route('news.show', $post))
        ->assertSuccessful()
        ->assertSee('Berita Baru Sekolah');
});
