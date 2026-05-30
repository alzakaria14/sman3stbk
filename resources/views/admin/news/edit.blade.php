@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('heading', 'Edit berita')
@section('eyebrow', 'Manajemen konten')

@section('actions')
    @if ($post->isPublished())
        <a href="{{ route('news.show', $post) }}" class="site-button-muted w-full sm:w-auto">Lihat berita</a>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.news.update', $post) }}" enctype="multipart/form-data" class="space-y-10">
        @include('admin.news._form')
    </form>
@endsection
