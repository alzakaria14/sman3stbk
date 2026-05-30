<?php

namespace App\Models;

use Database\Factories\SchoolSettingFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SchoolSetting extends Model
{
    /** @use HasFactory<SchoolSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'school_name',
        'site_name',
        'tagline',
        'logo_path',
        'hero_image_path',
        'npsn',
        'accreditation',
        'principal_name',
        'established_year',
        'establishment_decree',
        'operational_permit',
        'school_schedule',
        'coordinates',
        'address',
        'phone',
        'email',
        'about',
        'vision',
        'mission',
        'employee_data',
    ];

    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return [
            'school_name' => 'SMA Negeri 3 Martapura',
            'site_name' => 'SMA Negeri 3 Martapura',
            'tagline' => 'Terwujudnya insan berprestasi, berkarakter, mandiri dan peduli lingkungan.',
            'npsn' => '69991777',
            'accreditation' => null,
            'principal_name' => "Hj. Umi Masfi'ah, M.Pd",
            'established_year' => 2019,
            'establishment_decree' => '188.44/0791/KUM/2019',
            'operational_permit' => '503//1/DS-DPMPTSP/X/2019',
            'school_schedule' => 'Sehari Penuh/5 hari',
            'coordinates' => '-3.336065, 114.797672',
            'address' => 'Jl. Martapura Lama RT.01 Desa Sungai Rangas Ulu, Kec. Martapura Barat, Kab. Banjar Kalimantan Selatan',
            'phone' => null,
            'email' => null,
            'about' => 'SMA Negeri 3 Martapura adalah satuan pendidikan menengah atas di Kecamatan Martapura Barat, Kabupaten Banjar, Kalimantan Selatan. Sekolah menyelenggarakan pendidikan sehari penuh selama lima hari dengan komitmen pada prestasi, karakter, kemandirian, dan kepedulian lingkungan.',
            'vision' => 'Terwujudnya insan berprestasi, berkarakter, mandiri dan peduli lingkungan.',
            'mission' => "Melaksanakan pembelajaran, yang menerapkan prinsip berkesadaran, bermakna, dan menggembirakan\nMelaksanakan pembelajaran yang interaktif yang mendukung digitalisasi sekolah\nMelaksanakan asesmen, pembimbingan dan pelayanan yang berkualitas dan berpusat kepada murid\nMengikutkan murid dalam kegiatan lomba-lomba baik akademik maupun non akademik\nSecara bertahap melengkapi sarana dan prasarana pendidikan sesuai dengan kebutuhan dan perkembangan ilmu pengetahuan dan teknologi\nMenjalin kemitraan antara guru, murid, orang tua murid komunitas dan masyarakat\nMenanamkan keimanan dan ketakwaan melalui kegiatan tadarus Al-Qur'an, sholat berjamaah dan kegiatan keagamaan lainnya\nMelaksanakan pembelajaran kolaboratif inquiri\nMelaksanakan kegiatan ekstra kurikuler sesuai dengan minat dan bakat murid\nMengadakan kegiatan gerakan literasi sekolah untuk mengembangkan budaya membaca dalam kehidupan sehari-hari\nMelaksanakan kegiatan yang mendukung tercapainya profil dimensi lulusan disesuaikan dengan karakteristik lingkungan sekolah\nMenanamkan sikap mandiri dalam belajar dan mandiri dalam kehidupan dengan mengembangkan kegiatan wirausaha\nMenjadikan lingkungan sekolah yang bersih, indah, terpelihara dan lestari, aman, nyaman untuk mendukung terwujudnya sekolah ramah anak dan ramah lingkungan\nMewujudkan kepedulian sekolah terhadap kelestarian lingkungan dan kepekaan sosial untuk turut serta mencegah dan mengatasi pencemaran dan kerusakan lingkungan",
            'employee_data' => "Hj. Umi Masfi'ah, M.Pd - Kepala SMA Negeri 3 Martapura\nRahma Lutfi Habibah, S.Pd - Guru Matematika - Wakasek Humas\nIndah Novita Sari, S.Pd - Guru Bahasa Indonesia - Wakasek Kurikulum\nNurlaili Ramadhani, S.Pd - Guru PAI - Wakasek Kesiswaan\nSoraya Audina Nurrahma, S.Pd - Guru Seni Budaya - Wakasek Sarana dan Prasarana\nMuhammad Nazaruddin, S.Pd - Guru PJOK\nHerni Novita, S.Pd - Guru Geografi\nFlorentina Pratiwiningtyas, S.Pd - Guru Sosiologi\nNor Ika Handayani, S.Pd - Guru Biologi\nMiftahurrizqiyah, S.Pd - Guru TIK\nKhairil Anshari, S.Pd - Guru PKW/Fisika\nNora, S.Pd - Guru Ekonomi\nAsranudin, S.Pd - Guru Kimia\nMuhammad Azhari Mutaqin, S.Pd - Guru Sosiologi\nMuhammad Ibnu Arabi, S.Pd - Guru PPKN\nRama Rezky Yusuf, S.Pd - Guru Bahasa Inggris\nAmanda Syahputeri Kamal, S.Pd - Guru PPKN\nIsmi Dwi Mahrotin, S.Pd - Guru BK\nSiti Hardiyanti, S.Pd - Guru Sejarah Indonesia\nZaida Maliya, S.Pd - Guru Kimia\nPani, SE - Kepala Tata Usaha\nMuhammad Bayu Afansa Putra, S.Pd - Pelaksana Urusan Administrasi Persuratan & Pengarsipan\nBima Dwi Nugraha Sakti, S.P - Pelaksana Urusan Administrasi Hubungan Sekolah dengan Masyarakat\nUmmi Hani - Tenaga Administrasi Sarana & Prasarana\nAbdul Aziz Fathoni - Tenaga Administrasi Sarana & Prasarana\nRatna Ardiyanti, S.Si - Pelaksana Urusan Administrasi Sarana & Prasarana\nMuhammad Syarifudin, S.Pd - Penjaga Sekolah\nM. Fitrian Noor - Tenaga Kebersihan\nM. Jam'ani - Penjaga Sekolah",
        ];
    }

    public static function current(): self
    {
        return self::query()->first() ?? self::query()->create(self::defaults());
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'established_year' => 'integer',
        ];
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->logo_path ? Storage::disk('public')->url($this->logo_path) : null);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function displayName(): Attribute
    {
        return Attribute::get(fn (): string => $this->site_name ?: $this->school_name);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function heroImageUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->hero_image_path
            ? Storage::disk('public')->url($this->hero_image_path)
            : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=2400&q=80');
    }
}
