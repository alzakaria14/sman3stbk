@extends('layouts.public')

@section('title', $schoolSetting->display_name.' · Berita')

@section('content')
    <section class="relative flex min-h-[60vh] items-center overflow-hidden px-4 pt-14 text-white md:px-8">
        <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=2200&q=80" alt="Berita dan publikasi sekolah" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/25"></div>
        <div class="relative mx-auto w-full max-w-[1383px] text-center">
            <h1 class="text-[2.5rem] font-medium leading-tight">Berita sekolah</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 md:text-[1.375rem] md:leading-7">Agenda, pengumuman, dan cerita terbaru dari lingkungan sekolah.</p>
        </div>
    </section>

    <section class="px-4 py-16 md:px-8">
        <div class="mx-auto max-w-[1383px]">
            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($posts as $post)
                    <article>
                        <a href="{{ route('news.show', $post) }}" class="group block">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="aspect-[16/10] w-full rounded-lg object-cover">
                            <div class="py-5">
                                <p class="text-sm text-pewter">{{ $post->published_at?->translatedFormat('d M Y') }}</p>
                                <h2 class="mt-2 text-[1.0625rem] font-medium leading-6 text-carbon group-hover:underline">{{ $post->title }}</h2>
                                <p class="mt-3 text-sm leading-6 text-graphite">{{ $post->excerpt }}</p>
                            </div>
                        </a>
                    </article>
                @empty
                    <p class="text-sm text-graphite">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
