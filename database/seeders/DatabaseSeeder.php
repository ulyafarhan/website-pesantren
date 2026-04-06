<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Brochure;
use App\Models\ClassProgram;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User (Admin & Editor)
        $admin = User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@pesantrenkita.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        $editor = User::create([
            'name' => 'Tim Redaksi Berita',
            'email' => 'editor@pesantrenkita.com',
            'password' => Hash::make('password'),
            'role' => 'EDITOR',
        ]);

        // 2. Pengaturan Website
        SiteSetting::create([
            'site_name' => 'Pondok Pesantren Al-Hidayah Nusantara',
            'site_description' => 'Mewujudkan Generasi Qurani yang Berakhlakul Karimah, Berwawasan Global, dan Unggul dalam Teknologi Modern.',
            'logo_url' => 'settings/logo/logo-default.png',
            'favicon_url' => 'settings/favicon/favicon.ico',
            'email' => 'info@alhidayah.sch.id',
            'phone' => '021-12345678',
            'address' => 'Jl. Pendidikan No. 45, Kecamatan Sukadamai, Kota Mandiri, Jawa Barat',
            'google_maps_url' => 'https://maps.google.com/?q=pesantren',
            'facebook_url' => 'https://facebook.com/alhidayah',
            'instagram_url' => 'https://instagram.com/alhidayah_nu',
            'youtube_url' => 'https://youtube.com/c/AlHidayahTV',
            'is_maintenance' => false,
        ]);

        // 3. Fasilitas
        $facilities = [
            ['name' => 'Masjid Jami Al-Ikhlas', 'description' => 'Masjid pusat kegiatan ibadah santri dengan kapasitas 1.500 jamaah.'],
            ['name' => 'Asrama Santri Terpadu', 'description' => 'Gedung asrama bertingkat dengan fasilitas tempat tidur nyaman dan keamanan 24 jam.'],
            ['name' => 'Laboratorium Komputer', 'description' => 'Fasilitas pembelajaran IT modern dengan koneksi internet cepat.'],
            ['name' => 'Perpustakaan Digital', 'description' => 'Koleksi kitab kuning klasik dan buku pengetahuan umum dalam format digital dan cetak.'],
            ['name' => 'Gedung Olahraga (GOR)', 'description' => 'Fasilitas futsal, basket, dan badminton untuk mendukung kebugaran santri.'],
            ['name' => 'Kantin Sehat Mandiri', 'description' => 'Menyediakan makanan bergizi yang diolah higienis untuk konsumsi harian santri.'],
        ];
        foreach ($facilities as $f) Facility::create($f);

        // 4. Program Kelas/Akademik
        $programs = [
            ['name' => 'Tahfidz Al-Quran 30 Juz', 'description' => 'Program intensif menghafal Al-Quran dengan metode talaqqi dan murajaah rutin.'],
            ['name' => 'Kajian Kitab Kuning', 'description' => 'Pendalaman literatur klasik Islam meliputi Fiqih, Aqidah, Akhlak, dan Nahwu Shorof.'],
            ['name' => 'English & Arabic Club', 'description' => 'Penguasaan bahasa asing secara aktif melalui praktek percakapan harian.'],
            ['name' => 'Pendidikan Formal (SMP/SMA)', 'description' => 'Kurikulum nasional yang dipadukan dengan nilai-nilai kepesantrenan.'],
        ];
        foreach ($programs as $p) ClassProgram::create($p);

        // 5. Galeri Kegiatan
        for ($i = 1; $i <= 8; $i++) {
            Gallery::create([
                'title' => 'Kegiatan Santri Ke-' . $i,
                'description' => 'Dokumentasi momen berharga kegiatan belajar mengajar dan ekstrakurikuler santri.',
                'image_url' => 'galleries/photo-' . $i . '.jpg',
            ]);
        }

        // 6. Testimoni
        $testimonials = [
            ['name' => 'Bpk. Herman Susanto', 'role' => 'Wali Santri', 'message' => 'Sangat puas dengan perkembangan akhlak putra kami selama belajar di sini.'],
            ['name' => 'Siti Aminah', 'role' => 'Alumni (2020)', 'message' => 'Bekal ilmu agama dan bahasa di pesantren sangat membantu saya di bangku perkuliahan.'],
            ['name' => 'Ust. Fauzan Azhari', 'role' => 'Tokoh Masyarakat', 'message' => 'Pesantren ini menjadi mercusuar pendidikan Islam bagi warga sekitar.'],
        ];
        foreach ($testimonials as $t) Testimonial::create($t);

        // 7. Brosur
        Brochure::create(['title' => 'Panduan Pendaftaran 2026', 'version' => '1.0', 'file_url' => 'brochures/guide-2026.pdf']);
        Brochure::create(['title' => 'Kurikulum Pendidikan', 'version' => '2026', 'file_url' => 'brochures/curriculum.pdf']);

        // 8. Artikel Berita
        for ($i = 1; $i <= 10; $i++) {
            $title = "Update Kegiatan Pesantren Minggu Ke-$i";
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => "Ringkasan informasi mengenai perkembangan terbaru di lingkungan pesantren pada minggu ke-$i.",
                'content' => "<p>Ini adalah konten berita lengkap mengenai kegiatan rutin santri, prestasi yang diraih, maupun agenda kunjungan tokoh ke pesantren.</p>",
                'is_published' => true,
                'author_id' => $editor->id,
                'published_at' => now()->subDays($i),
            ]);
        }

        // 9. Gelombang Pendaftaran (PPDB)
        $period = RegistrationPeriod::create([
            'name' => 'Gelombang Utama TA 2026/2027',
            'start_date' => '2026-01-01',
            'end_date' => '2026-07-31',
            'quota' => 200,
            'registration_fee' => 250000,
            'is_active' => true,
            'form_schema' => [
                ['field_name' => 'nama_ayah', 'label' => 'Nama Lengkap Ayah', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'asal_sekolah', 'label' => 'Sekolah Asal', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'hobi', 'label' => 'Hobi Santri', 'type' => 'text', 'is_required' => false],
            ],
            'document_schema' => [
                ['document_key' => 'kk', 'label' => 'Scan Kartu Keluarga', 'is_required' => true],
                ['document_key' => 'akta', 'label' => 'Scan Akta Kelahiran', 'is_required' => true],
            ],
        ]);

        // 10. Data Pendaftar (Calon Santri)
        $pendaftar = [
            ['name' => 'Muhammad Rizky', 'gender' => 'L', 'nik' => '3201010101010001'],
            ['name' => 'Aisyah Putri', 'gender' => 'P', 'nik' => '3201010101010002'],
            ['name' => 'Fadhil Arsyad', 'gender' => 'L', 'nik' => '3201010101010003'],
            ['name' => 'Nabila Syakieb', 'gender' => 'P', 'nik' => '3201010101010004'],
            ['name' => 'Zaky Mubarok', 'gender' => 'L', 'nik' => '3201010101010005'],
        ];

        foreach ($pendaftar as $idx => $p) {
            Registration::create([
                'registration_period_id' => $period->id,
                'registration_number' => 'REG-' . now()->format('Ymd') . '00' . ($idx + 1),
                'full_name' => $p['name'],
                'nik' => $p['nik'],
                'gender' => $p['gender'],
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '2012-05-15',
                'phone_number' => '08123456789' . $idx,
                'status' => $idx === 0 ? 'VERIFIED' : 'PENDING',
                'data' => [
                    'nama_ayah' => 'Ayah dari ' . $p['name'],
                    'asal_sekolah' => 'SDN Merdeka 01',
                    'hobi' => 'Membaca',
                ],
            ]);
        }
    }
}