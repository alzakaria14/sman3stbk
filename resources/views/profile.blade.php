@extends('layouts.public')

@section('title', $schoolSetting->display_name.' · Profil')

@section('content')
    @php
        $missionItems = collect(preg_split('/\r\n|\r|\n/', (string) $schoolSetting->mission))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values();
        $employeeItems = collect(preg_split('/\r\n|\r|\n/', (string) $schoolSetting->employee_data))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values();
        $mapUrl = $schoolSetting->coordinates
            ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($schoolSetting->coordinates)
            : null;
    @endphp

    <section class="relative flex min-h-[78vh] items-end overflow-hidden px-4 pb-14 pt-24 text-white md:px-8">
        <img src="{{ $schoolSetting->hero_image_url }}" alt="{{ $schoolSetting->school_name }}" class="ambient-photo absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative mx-auto w-full max-w-[1383px]">
            <div class="max-w-4xl">
                <p class="animate-reveal text-sm font-medium">Profil Sekolah</p>
                <h1 class="animate-reveal animate-delay-1 mt-3 text-[2.5rem] font-medium leading-tight">{{ $schoolSetting->school_name }}</h1>
                <p class="animate-reveal animate-delay-2 mt-4 max-w-2xl text-sm leading-6 md:text-[1.375rem] md:leading-7">{{ $schoolSetting->vision }}</p>
            </div>
        </div>
    </section>

    <section class="px-4 py-18 md:px-8 md:py-24">
        <div class="mx-auto grid max-w-[1383px] gap-12 lg:grid-cols-[0.85fr_1.15fr]">
            <div class="animate-reveal">
                <p class="text-sm font-medium text-pewter">Identitas</p>
                <h2 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">Data resmi sekolah</h2>
                <p class="mt-5 whitespace-pre-line text-sm leading-7 text-graphite">{{ $schoolSetting->about }}</p>
            </div>

            <div class="grid gap-3 text-sm sm:grid-cols-2">
                <div class="profile-metric animate-reveal animate-delay-1">
                    <p class="text-pewter">Kepala Sekolah</p>
                    <p class="mt-2 text-[1.0625rem] font-medium leading-6 text-carbon">{{ $schoolSetting->principal_name }}</p>
                </div>
                <div class="profile-metric animate-reveal animate-delay-1">
                    <p class="text-pewter">NPSN</p>
                    <p class="mt-2 text-[1.0625rem] font-medium text-carbon">{{ $schoolSetting->npsn }}</p>
                </div>
                <div class="profile-metric animate-reveal animate-delay-2">
                    <p class="text-pewter">Waktu Penyelenggaraan</p>
                    <p class="mt-2 text-[1.0625rem] font-medium text-carbon">{{ $schoolSetting->school_schedule }}</p>
                </div>
                <div class="profile-metric animate-reveal animate-delay-2">
                    <p class="text-pewter">Titik Koordinat</p>
                    @if ($mapUrl)
                        <a href="{{ $mapUrl }}" target="_blank" rel="noreferrer" class="mt-2 inline-flex text-[1.0625rem] font-medium text-carbon hover:underline">{{ $schoolSetting->coordinates }}</a>
                    @else
                        <p class="mt-2 text-[1.0625rem] font-medium text-carbon">-</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="bg-carbon px-4 py-18 text-white md:px-8 md:py-24">
        <div class="mx-auto grid max-w-[1383px] gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="animate-reveal">
                <p class="text-sm font-medium text-white/70">Legalitas</p>
                <h2 class="mt-2 text-[2rem] font-medium leading-tight">Dokumen dan alamat</h2>
            </div>
            <div class="grid gap-3 text-sm md:grid-cols-2">
                <div class="border border-white/15 p-5">
                    <p class="text-white/65">SK Pendirian Sekolah</p>
                    <p class="mt-2 text-[1.0625rem] font-medium">{{ $schoolSetting->establishment_decree }}</p>
                </div>
                <div class="border border-white/15 p-5">
                    <p class="text-white/65">SK Izin Operasional</p>
                    <p class="mt-2 text-[1.0625rem] font-medium">{{ $schoolSetting->operational_permit }}</p>
                </div>
                <div class="border border-white/15 p-5 md:col-span-2">
                    <p class="text-white/65">Alamat</p>
                    <p class="mt-2 text-[1.0625rem] font-medium leading-7">{{ $schoolSetting->address }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-ash px-4 py-18 md:px-8 md:py-24">
        <div class="mx-auto grid max-w-[1383px] gap-12 lg:grid-cols-[0.85fr_1.15fr]">
            <div class="animate-reveal">
                <p class="text-sm font-medium text-pewter">Visi dan Misi</p>
                <h2 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">{{ $schoolSetting->vision }}</h2>
            </div>
            <div class="grid gap-3">
                @foreach ($missionItems as $mission)
                    <div class="mission-row animate-reveal">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-white text-sm font-medium text-carbon">{{ $loop->iteration }}</span>
                        <p class="text-sm leading-7 text-graphite">{{ $mission }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 py-18 md:px-8 md:py-24">
        <div class="mx-auto max-w-[1383px]">
            <div class="animate-reveal flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-medium text-pewter">Pegawai/Karyawan</p>
                    <h2 class="mt-2 text-[2rem] font-medium leading-tight text-carbon">Data SMAN 3 Martapura Tahun 2025/2026</h2>
                </div>
                <p class="text-sm text-pewter">{{ $employeeItems->count() }} orang terdata</p>
            </div>

            <div class="mt-10 grid gap-x-8 gap-y-3 md:grid-cols-2">
                @foreach ($employeeItems as $employee)
                    @php
                        [$employeeName, $employeeRole] = array_pad(explode(' - ', $employee, 2), 2, '');
                    @endphp
                    <div class="staff-row animate-reveal">
                        <span class="mt-1 flex h-7 w-7 shrink-0 items-center justify-center rounded-sm bg-ash text-xs font-medium text-carbon">{{ $loop->iteration }}</span>
                        <div>
                            <p class="text-sm font-medium leading-6 text-carbon">{{ $employeeName }}</p>
                            @if ($employeeRole)
                                <p class="text-sm leading-6 text-pewter">{{ $employeeRole }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
