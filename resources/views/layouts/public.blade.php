<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', $schoolSetting->display_name)</title>
        <meta name="description" content="{{ $schoolSetting->tagline }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen pb-20 font-sans antialiased">
        <header class="fixed inset-x-0 top-0 z-40 bg-white/75 backdrop-blur-md">
            <nav class="mx-auto flex h-14 max-w-[1383px] items-center justify-between gap-4 px-4 md:px-8">
                <a href="{{ route('home') }}" class="animate-reveal flex min-w-0 items-center gap-3 text-sm font-medium text-carbon">
                    @if ($schoolSetting->logo_url)
                        <img src="{{ $schoolSetting->logo_url }}" alt="{{ $schoolSetting->display_name }}" class="h-8 w-8 rounded-sm object-cover">
                    @else
                        <span class="flex h-8 w-8 items-center justify-center rounded-sm bg-carbon text-xs font-medium text-white">S3</span>
                    @endif
                    <span class="truncate">{{ $schoolSetting->display_name }}</span>
                </a>

                <div class="animate-reveal animate-delay-1 hidden items-center gap-1 md:flex">
                    <a href="{{ route('home') }}" class="rounded-sm px-4 py-2 text-sm font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('home') ? 'bg-ash text-carbon' : 'text-graphite' }}">Beranda</a>
                    <a href="{{ route('profile') }}" class="rounded-sm px-4 py-2 text-sm font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('profile') ? 'bg-ash text-carbon' : 'text-graphite' }}">Profil</a>
                    <a href="{{ route('news.index') }}" class="rounded-sm px-4 py-2 text-sm font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('news.*') ? 'bg-ash text-carbon' : 'text-graphite' }}">Berita</a>
                </div>

                <div class="hidden items-center gap-1 md:flex">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-sm px-4 py-2 text-sm font-medium text-graphite transition-colors duration-300 hover:bg-ash">Admin</a>
                </div>

                <details class="relative md:hidden">
                    <summary class="list-none rounded-sm px-4 py-2 text-sm font-medium text-carbon transition-colors duration-300 hover:bg-ash">Menu</summary>
                    <div class="absolute right-0 mt-2 w-48 bg-white p-2">
                        <a href="{{ route('home') }}" class="block rounded-sm px-3 py-2 text-sm font-medium text-graphite hover:bg-ash">Beranda</a>
                        <a href="{{ route('profile') }}" class="block rounded-sm px-3 py-2 text-sm font-medium text-graphite hover:bg-ash">Profil</a>
                        <a href="{{ route('news.index') }}" class="block rounded-sm px-3 py-2 text-sm font-medium text-graphite hover:bg-ash">Berita</a>
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-sm px-3 py-2 text-sm font-medium text-graphite hover:bg-ash">Admin</a>
                    </div>
                </details>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="bg-white">
            <div class="mx-auto grid max-w-[1383px] gap-8 px-4 py-12 text-sm text-pewter md:grid-cols-[1.5fr_1fr_1fr] md:px-8">
                <div class="space-y-3">
                    <p class="font-medium text-carbon">{{ $schoolSetting->display_name }}</p>
                    <p class="max-w-xl leading-6">{{ $schoolSetting->tagline }}</p>
                </div>
                <div class="space-y-2">
                    <p class="font-medium text-carbon">Alamat</p>
                    <p class="leading-6">{{ $schoolSetting->address }}</p>
                </div>
                <div class="space-y-2">
                    <p class="font-medium text-carbon">Kontak</p>
                    @if ($schoolSetting->phone)
                        <p>{{ $schoolSetting->phone }}</p>
                    @endif
                    @if ($schoolSetting->email)
                        <p>{{ $schoolSetting->email }}</p>
                    @endif
                </div>
            </div>
        </footer>

        <!-- <div class="fixed inset-x-0 bottom-0 z-40 border-t border-cloud bg-white">
            <div class="mx-auto flex min-h-14 max-w-[1383px] flex-col justify-center gap-2 px-4 py-3 text-sm text-graphite md:flex-row md:items-center md:justify-between md:px-8">
                <span class="font-medium text-carbon">Butuh informasi sekolah?</span>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <span>{{ $schoolSetting->address }}</span>
                    <a href="{{ route('news.index') }}" class="site-button-muted">Lihat berita</a>
                </div>
            </div>
        </div> -->
        @stack('scripts')
    </body>
</html>
