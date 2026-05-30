<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel Admin') · {{ $schoolSetting->display_name }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white font-sans antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
            <aside class="border-b border-cloud bg-white lg:min-h-screen lg:border-b-0 lg:border-r">
                <div class="flex h-14 items-center justify-between px-4 lg:px-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-3 text-sm font-medium text-carbon">
                        @if ($schoolSetting->logo_url)
                            <img src="{{ $schoolSetting->logo_url }}" alt="{{ $schoolSetting->display_name }}" class="h-8 w-8 rounded-sm object-cover">
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-sm bg-carbon text-xs font-medium text-white">S3</span>
                        @endif
                        <span class="truncate">Admin Sekolah</span>
                    </a>
                </div>

                <nav class="flex gap-1 overflow-x-auto px-4 pb-4 text-sm lg:flex-col lg:overflow-visible lg:px-3">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-sm px-3 py-2 font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('admin.dashboard') ? 'bg-ash text-carbon' : 'text-graphite' }}">Dashboard</a>
                    <a href="{{ route('admin.settings.edit') }}" class="rounded-sm px-3 py-2 font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('admin.settings.*') ? 'bg-ash text-carbon' : 'text-graphite' }}">Identitas</a>
                    <a href="{{ route('admin.news.index') }}" class="rounded-sm px-3 py-2 font-medium transition-colors duration-300 hover:bg-ash {{ request()->routeIs('admin.news.*') ? 'bg-ash text-carbon' : 'text-graphite' }}">Berita</a>
                    <a href="{{ route('home') }}" class="rounded-sm px-3 py-2 font-medium text-graphite transition-colors duration-300 hover:bg-ash">Lihat situs</a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="lg:mt-auto">
                        @csrf
                        <button type="submit" class="w-full rounded-sm px-3 py-2 text-left font-medium text-graphite transition-colors duration-300 hover:bg-ash">Keluar</button>
                    </form>
                </nav>
            </aside>

            <main class="min-w-0">
                <div class="mx-auto max-w-6xl px-4 py-8 md:px-8">
                    <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-sm text-pewter">@yield('eyebrow', 'Panel Admin')</p>
                            <h1 class="mt-1 text-[2rem] font-medium leading-tight text-carbon">@yield('heading', 'Dashboard')</h1>
                        </div>
                        @yield('actions')
                    </div>

                    @if (session('status'))
                        <div class="mb-6 rounded-sm bg-ash px-4 py-3 text-sm font-medium text-carbon">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-sm bg-ash px-4 py-3 text-sm text-carbon">
                            <p class="font-medium">Periksa kembali input berikut.</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-pewter">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
