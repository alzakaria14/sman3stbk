@extends('layouts.public')

@section('title', $schoolSetting->display_name.' · Beranda')

@section('content')
    <section class="relative flex min-h-screen items-center overflow-hidden px-4 pt-14 text-white md:px-8">
        <img src="{{ $schoolSetting->hero_image_url }}" alt="{{ $schoolSetting->display_name }}" class="ambient-photo absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/25"></div>
        <div class="relative mx-auto flex min-h-[calc(100vh-3.5rem)] w-full max-w-[1383px] flex-col items-center justify-center text-center">
            <h1 class="animate-reveal max-w-4xl text-[2.5rem] font-medium leading-tight md:text-[2.5rem]">{{ $schoolSetting->display_name }}</h1>
            <p class="animate-reveal animate-delay-1 mt-3 max-w-2xl text-sm leading-6 md:text-[1.375rem] md:leading-7">{{ $schoolSetting->tagline }}</p>
            <div class="animate-reveal animate-delay-2 mt-8 flex w-full max-w-md flex-col gap-3 sm:flex-row sm:justify-center">
                <a href="{{ route('news.index') }}" class="site-button-primary sm:w-[200px]">Berita terbaru</a>
                <a href="{{ route('profile') }}" class="site-button-secondary sm:w-[200px]">Profil sekolah</a>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-20 md:min-h-screen md:px-8">
        <div class="mx-auto grid max-w-[1383px] items-center gap-12 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-medium text-pewter">Profil</p>
                <h2 class="mt-2 max-w-xl text-[2rem] font-medium leading-tight text-carbon">Sekolah berprestasi, berkarakter, mandiri, dan peduli lingkungan.</h2>
                <p class="mt-5 max-w-2xl text-sm leading-6 text-graphite">{{ $schoolSetting->about }}</p>
                <div class="mt-8 grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
                    <div>
                        <p class="text-pewter">NPSN</p>
                        <p class="mt-1 font-medium text-carbon">{{ $schoolSetting->npsn }}</p>
                    </div>
                    <div>
                        <p class="text-pewter">Akreditasi</p>
                        <p class="mt-1 font-medium text-carbon">{{ $schoolSetting->accreditation }}</p>
                    </div>
                    <div>
                        <p class="text-pewter">Berdiri</p>
                        <p class="mt-1 font-medium text-carbon">{{ $schoolSetting->established_year }}</p>
                    </div>
                    <div>
                        <p class="text-pewter">Kepala Sekolah</p>
                        <p class="mt-1 font-medium text-carbon">{{ $schoolSetting->principal_name }}</p>
                    </div>
                </div>
            </div>
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80" alt="Perpustakaan sekolah" class="aspect-[4/3] w-full rounded-lg object-cover">
        </div>
    </section>

    <section class="bg-ash px-4 py-20 md:min-h-screen md:px-8">
        <div class="mx-auto max-w-[1383px]">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-medium text-pewter">Berita</p>
                    <h2 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">Pembaruan dari sekolah</h2>
                </div>
                <a href="{{ route('news.index') }}" class="site-button-primary w-full sm:w-[200px]">Semua berita</a>
            </div>

            <div class="mt-10 grid gap-4 md:grid-cols-3">
                @forelse ($latestPosts as $post)
                    <article class="bg-white">
                        <a href="{{ route('news.show', $post) }}" class="group block">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="aspect-[16/10] w-full rounded-lg object-cover">
                            <div class="px-1 py-5">
                                <p class="text-sm text-pewter">{{ $post->published_at?->translatedFormat('d M Y') }}</p>
                                <h3 class="mt-2 text-[1.0625rem] font-medium leading-6 text-carbon group-hover:underline">{{ $post->title }}</h3>
                                <p class="mt-3 text-sm leading-6 text-graphite">{{ $post->excerpt }}</p>
                            </div>
                        </a>
                    </article>
                @empty
                    <p class="text-sm text-graphite">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
