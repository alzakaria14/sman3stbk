<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk Admin · {{ $schoolSetting->display_name }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white font-sans antialiased">
        <main class="grid min-h-screen lg:grid-cols-[1.1fr_0.9fr]">
            <section class="relative hidden overflow-hidden lg:block">
                <img src="{{ $schoolSetting->hero_image_url }}" alt="{{ $schoolSetting->display_name }}" class="ambient-photo absolute inset-0 h-full w-full object-cover">
            </section>
            <section class="flex items-center px-4 py-12 md:px-10">
                <div class="mx-auto w-full max-w-md">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-sm font-medium text-carbon">
                        @if ($schoolSetting->logo_url)
                            <img src="{{ $schoolSetting->logo_url }}" alt="{{ $schoolSetting->display_name }}" class="h-9 w-9 rounded-sm object-cover">
                        @else
                            <span class="flex h-9 w-9 items-center justify-center rounded-sm bg-carbon text-xs font-medium text-white">S3</span>
                        @endif
                        <span>{{ $schoolSetting->display_name }}</span>
                    </a>

                    <div class="mt-12">
                        <p class="text-sm text-pewter">Panel Admin</p>
                        <h1 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">Masuk untuk mengelola konten.</h1>
                    </div>

                    @if ($errors->any())
                        <div class="mt-8 rounded-sm bg-ash px-4 py-3 text-sm text-carbon">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                        @csrf
                        <div class="space-y-2">
                            <label for="email" class="site-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="site-field">
                        </div>
                        <div class="space-y-2">
                            <label for="password" class="site-label">Password</label>
                            <input id="password" name="password" type="password" required class="site-field">
                        </div>
                        <label class="flex items-center gap-2 text-sm text-graphite">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded-sm border-cloud text-electric-blue">
                            Ingat sesi ini
                        </label>
                        <button type="submit" class="site-button-primary w-full">Masuk</button>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>
