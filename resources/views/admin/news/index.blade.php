@extends('layouts.admin')

@section('title', 'Berita')
@section('heading', 'Berita')
@section('eyebrow', 'Manajemen konten')

@section('actions')
    <a href="{{ route('admin.news.create') }}" class="site-button-primary w-full sm:w-auto">Tulis berita</a>
@endsection

@section('content')
    <div class="overflow-x-auto">
        <table class="w-full min-w-[840px] text-left text-sm">
            <thead class="border-b border-cloud text-pewter">
                <tr>
                    <th class="py-3 pr-4 font-medium">Judul</th>
                    <th class="py-3 pr-4 font-medium">Slug</th>
                    <th class="py-3 pr-4 font-medium">Status</th>
                    <th class="py-3 pr-4 font-medium">Tanggal</th>
                    <th class="py-3 pr-4 font-medium"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cloud">
                @forelse ($posts as $post)
                    <tr>
                        <td class="py-4 pr-4">
                            <p class="font-medium text-carbon">{{ $post->title }}</p>
                            <p class="mt-1 max-w-lg truncate text-pewter">{{ $post->excerpt }}</p>
                        </td>
                        <td class="py-4 pr-4 text-graphite">{{ $post->slug }}</td>
                        <td class="py-4 pr-4 text-graphite">{{ $post->isPublished() ? 'Terbit' : 'Draft' }}</td>
                        <td class="py-4 pr-4 text-graphite">{{ $post->published_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="py-4 pr-4">
                            <div class="flex justify-end gap-3">
                                @if ($post->isPublished())
                                    <a href="{{ route('news.show', $post) }}" class="font-medium text-pewter hover:underline">Lihat</a>
                                @endif
                                <a href="{{ route('admin.news.edit', $post) }}" class="font-medium text-pewter hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.news.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-pewter hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-graphite">Belum ada berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection
