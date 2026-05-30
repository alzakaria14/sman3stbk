@extends('layouts.admin')

@section('title', 'Tulis Berita')
@section('heading', 'Tulis berita')
@section('eyebrow', 'Manajemen konten')

@section('content')
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-10">
        @include('admin.news._form')
    </form>
@endsection
