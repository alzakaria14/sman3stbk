@extends('layouts.admin')

@section('title', 'Identitas Sekolah')
@section('heading', 'Identitas sekolah')
@section('eyebrow', 'Pengaturan')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <section class="grid gap-6 border-t border-cloud pt-8 lg:grid-cols-[260px_1fr]">
            <div>
                <h2 class="text-[1.0625rem] font-medium text-carbon">Identitas utama</h2>
                <p class="mt-2 text-sm leading-6 text-pewter">Nama, logo, dan gambar utama yang tampil di situs publik.</p>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="site_name" class="site-label">Nama website</label>
                    <input id="site_name" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="site-field">
                    <p class="site-help">Nama yang tampil di navigasi, judul browser, dan footer.</p>
                </div>
                <div class="space-y-2">
                    <label for="school_name" class="site-label">Nama sekolah resmi</label>
                    <input id="school_name" name="school_name" value="{{ old('school_name', $setting->school_name) }}" class="site-field" required>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label for="tagline" class="site-label">Tagline</label>
                    <input id="tagline" name="tagline" value="{{ old('tagline', $setting->tagline) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="logo" class="site-label">Logo sekolah</label>
                    <input id="logo" name="logo" type="file" accept="image/*" class="site-field">
                    @if ($setting->logo_url)
                        <label class="flex items-center gap-2 text-sm text-graphite">
                            <input type="checkbox" name="remove_logo" value="1" class="h-4 w-4 rounded-sm border-cloud">
                            Hapus logo saat ini
                        </label>
                    @endif
                </div>
                <div class="space-y-2">
                    <label for="hero_image" class="site-label">Gambar utama</label>
                    <input id="hero_image" name="hero_image" type="file" accept="image/*" class="site-field">
                    @if ($setting->hero_image_path)
                        <label class="flex items-center gap-2 text-sm text-graphite">
                            <input type="checkbox" name="remove_hero_image" value="1" class="h-4 w-4 rounded-sm border-cloud">
                            Hapus gambar utama saat ini
                        </label>
                    @endif
                </div>
            </div>
        </section>

        <section class="grid gap-6 border-t border-cloud pt-8 lg:grid-cols-[260px_1fr]">
            <div>
                <h2 class="text-[1.0625rem] font-medium text-carbon">Data sekolah</h2>
                <p class="mt-2 text-sm leading-6 text-pewter">Informasi singkat untuk halaman profil dan footer.</p>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="npsn" class="site-label">NPSN</label>
                    <input id="npsn" name="npsn" value="{{ old('npsn', $setting->npsn) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="accreditation" class="site-label">Akreditasi</label>
                    <input id="accreditation" name="accreditation" value="{{ old('accreditation', $setting->accreditation) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="principal_name" class="site-label">Kepala sekolah</label>
                    <input id="principal_name" name="principal_name" value="{{ old('principal_name', $setting->principal_name) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="established_year" class="site-label">Tahun berdiri</label>
                    <input id="established_year" name="established_year" type="number" min="1900" max="2100" value="{{ old('established_year', $setting->established_year) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="school_schedule" class="site-label">Waktu penyelenggaraan</label>
                    <input id="school_schedule" name="school_schedule" value="{{ old('school_schedule', $setting->school_schedule) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="coordinates" class="site-label">Titik koordinat</label>
                    <input id="coordinates" name="coordinates" value="{{ old('coordinates', $setting->coordinates) }}" class="site-field">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label for="address" class="site-label">Alamat</label>
                    <input id="address" name="address" value="{{ old('address', $setting->address) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="phone" class="site-label">Telepon</label>
                    <input id="phone" name="phone" value="{{ old('phone', $setting->phone) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="email" class="site-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $setting->email) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="establishment_decree" class="site-label">SK pendirian sekolah</label>
                    <input id="establishment_decree" name="establishment_decree" value="{{ old('establishment_decree', $setting->establishment_decree) }}" class="site-field">
                </div>
                <div class="space-y-2">
                    <label for="operational_permit" class="site-label">SK izin operasional</label>
                    <input id="operational_permit" name="operational_permit" value="{{ old('operational_permit', $setting->operational_permit) }}" class="site-field">
                </div>
            </div>
        </section>

        <section class="grid gap-6 border-t border-cloud pt-8 lg:grid-cols-[260px_1fr]">
            <div>
                <h2 class="text-[1.0625rem] font-medium text-carbon">Profil naratif</h2>
                <p class="mt-2 text-sm leading-6 text-pewter">Teks panjang untuk halaman profil sekolah.</p>
            </div>
            <div class="space-y-5">
                <div class="space-y-2">
                    <label for="about" class="site-label">Tentang sekolah</label>
                    <textarea id="about" name="about" rows="5" class="site-field">{{ old('about', $setting->about) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label for="vision" class="site-label">Visi</label>
                    <textarea id="vision" name="vision" rows="3" class="site-field">{{ old('vision', $setting->vision) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label for="mission" class="site-label">Misi</label>
                    <textarea id="mission" name="mission" rows="10" class="site-field">{{ old('mission', $setting->mission) }}</textarea>
                    <p class="site-help">Tulis satu misi per baris.</p>
                </div>
                <div class="space-y-2">
                    <label for="employee_data" class="site-label">Data pegawai/karyawan</label>
                    <textarea id="employee_data" name="employee_data" rows="12" class="site-field">{{ old('employee_data', $setting->employee_data) }}</textarea>
                    <p class="site-help">Format: Nama - Jabatan. Tulis satu orang per baris.</p>
                </div>
            </div>
        </section>

        <div class="flex justify-end border-t border-cloud pt-8">
            <button type="submit" class="site-button-primary w-full sm:w-[200px]">Simpan</button>
        </div>
    </form>
@endsection
