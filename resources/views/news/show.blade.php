@extends('layouts.public')

@section('title', $post->title.' · '.$schoolSetting->display_name)

@section('content')
    <article>
        <section class="relative flex min-h-[70vh] items-end overflow-hidden px-4 pb-16 pt-24 text-white md:px-8">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-black/25"></div>
            <div class="relative mx-auto w-full max-w-[1000px] text-center">
                <p class="text-sm font-medium">{{ $post->published_at?->translatedFormat('d M Y') }}</p>
                <h1 class="mt-3 text-[2.5rem] font-medium leading-tight">{{ $post->title }}</h1>
                @if ($post->excerpt)
                    <p class="mx-auto mt-4 max-w-2xl text-sm leading-6 md:text-[1.375rem] md:leading-7">{{ $post->excerpt }}</p>
                @endif
            </div>
        </section>

        <section class="px-4 py-16 md:px-8">
            <div class="mx-auto max-w-[760px]">
                <div class="whitespace-pre-line text-sm leading-7 text-graphite">{{ $post->content }}</div>
            </div>
        </section>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="bg-ash px-4 py-16 md:px-8">
            <div class="mx-auto max-w-[1383px]">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm font-medium text-pewter">Berikutnya</p>
                        <h2 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">Berita lain</h2>
                    </div>
                    <a href="{{ route('news.index') }}" class="site-button-primary w-full sm:w-[200px]">Semua berita</a>
                </div>
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedPosts as $relatedPost)
                        <article>
                            <a href="{{ route('news.show', $relatedPost) }}" class="group block">
                                <img src="{{ $relatedPost->featured_image_url }}" alt="{{ $relatedPost->title }}" class="aspect-[16/10] w-full rounded-lg object-cover">
                                <div class="py-5">
                                    <p class="text-sm text-pewter">{{ $relatedPost->published_at?->translatedFormat('d M Y') }}</p>
                                    <h3 class="mt-2 text-[1.0625rem] font-medium leading-6 text-carbon group-hover:underline">{{ $relatedPost->title }}</h3>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
