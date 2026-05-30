@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('actions')
    <a href="{{ route('admin.news.create') }}" class="site-button-primary w-full sm:w-auto">Tulis berita</a>
@endsection

@section('content')
    <div class="grid gap-4 md:grid-cols-3">
        <div class="bg-ash p-5">
            <p class="text-sm text-pewter">Total berita</p>
            <p class="mt-2 text-[2rem] font-medium leading-tight text-carbon">{{ $totalPosts }}</p>
        </div>
        <div class="bg-ash p-5">
            <p class="text-sm text-pewter">Terbit</p>
            <p class="mt-2 text-[2rem] font-medium leading-tight text-carbon">{{ $publishedPosts }}</p>
        </div>
        <div class="bg-ash p-5">
            <p class="text-sm text-pewter">Draft</p>
            <p class="mt-2 text-[2rem] font-medium leading-tight text-carbon">{{ $draftPosts }}</p>
        </div>
    </div>

    <section class="mt-10">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-[1.0625rem] font-medium text-carbon">Berita terbaru</h2>
            <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-pewter hover:underline">Kelola semua</a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="border-b border-cloud text-pewter">
                    <tr>
                        <th class="py-3 pr-4 font-medium">Judul</th>
                        <th class="py-3 pr-4 font-medium">Status</th>
                        <th class="py-3 pr-4 font-medium">Tanggal</th>
                        <th class="py-3 pr-4 font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cloud">
                    @forelse ($latestPosts as $post)
                        <tr>
                            <td class="py-4 pr-4 font-medium text-carbon">{{ $post->title }}</td>
                            <td class="py-4 pr-4 text-graphite">{{ $post->isPublished() ? 'Terbit' : 'Draft' }}</td>
                            <td class="py-4 pr-4 text-graphite">{{ $post->published_at?->format('d M Y') ?? '-' }}</td>
                            <td class="py-4 pr-4 text-right">
                                <a href="{{ route('admin.news.edit', $post) }}" class="font-medium text-pewter hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-graphite">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
