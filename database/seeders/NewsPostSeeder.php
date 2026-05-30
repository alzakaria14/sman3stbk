<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::query()->where('is_admin', true)->first();

        collect([
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026',
                'excerpt' => 'Informasi awal mengenai jadwal, berkas, dan alur penerimaan peserta didik baru.',
                'content' => "Penerimaan peserta didik baru dibuka untuk calon siswa yang ingin bergabung dengan lingkungan belajar SMAN 3 Setibudi Karya.\n\nPanitia akan mengumumkan jadwal verifikasi, persyaratan berkas, dan kanal informasi resmi melalui website sekolah. Orang tua dan calon siswa diharapkan mengikuti pembaruan berkala agar tidak melewatkan tahapan penting.",
            ],
            [
                'title' => 'Kegiatan Literasi dan Riset Siswa',
                'excerpt' => 'Siswa mengikuti rangkaian literasi, diskusi ilmiah, dan presentasi karya sederhana.',
                'content' => "Program literasi dan riset menjadi ruang bagi siswa untuk berlatih membaca data, menyusun gagasan, dan mempresentasikan temuan secara runtut.\n\nKegiatan ini diharapkan memperkuat budaya akademik sekaligus melatih kepercayaan diri siswa dalam menyampaikan pendapat berbasis bukti.",
            ],
            [
                'title' => 'Penguatan Layanan Informasi Sekolah',
                'excerpt' => 'Website sekolah menjadi kanal utama publikasi agenda, berita, dan profil kelembagaan.',
                'content' => "Sekolah memperkuat layanan informasi digital agar warga sekolah dan masyarakat dapat mengakses pembaruan secara cepat.\n\nSetiap pengumuman dan berita akan dikelola melalui panel admin sehingga konten lebih tertata, konsisten, dan mudah ditemukan.",
            ],
        ])->each(function (array $post) use ($author): void {
            NewsPost::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    ...$post,
                    'user_id' => $author?->id,
                    'is_published' => true,
                    'published_at' => now()->subDays(fake()->numberBetween(1, 14)),
                ]
            );
        });
    }
}
