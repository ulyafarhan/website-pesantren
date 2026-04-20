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
        $admin = User::create([
            'name' => 'Administrator Darussaadah',
            'email' => 'admin@darussaadah.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'ADMIN',
        ]);

        $editor = User::create([
            'name' => 'Tim Redaksi Darussaadah',
            'email' => 'redaksi@darussaadah.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'EDITOR',
        ]);

        SiteSetting::create([
            'site_name' => 'Pesantren Darussaadah',
            'site_description' => 'Mencetak generasi Islami yang tafaqquh fiddin, berakhlak mulia, mandiri, dan mampu menjawab tantangan zaman berlandaskan Ahlussunnah wal Jamaah.',
            'logo_url' => 'settings/logo/darussaadah-logo.png',
            'favicon_url' => 'settings/favicon/favicon.ico',
            'email' => 'info@darussaadah.sch.id',
            'phone' => '081122334455',
            'address' => 'Mukim Teupin Raya, Kecamatan Glumpang Tiga, Kabupaten Pidie, Provinsi Aceh',
            'google_maps_url' => 'https://maps.google.com/',
            'facebook_url' => 'https://facebook.com/pesantrendarussaadah',
            'instagram_url' => 'https://instagram.com/darussaadah_teupinraya',
            'youtube_url' => 'https://youtube.com/c/DarussaadahMedia',
            'is_maintenance' => false,
        ]);

        $facilities = [
            ['name' => 'Masjid Jami\' Darussaadah', 'description' => 'Pusat ibadah dan kajian kitab kuning utama yang mampu menampung ribuan santri.'],
            ['name' => 'Gedung Asrama Putra', 'description' => 'Kompleks asrama putra yang representatif dengan sirkulasi udara yang baik dan pengawasan ketat.'],
            ['name' => 'Gedung Asrama Putri', 'description' => 'Kompleks asrama khusus putri yang aman, nyaman, dan terpisah sepenuhnya dari area putra.'],
            ['name' => 'Laboratorium Komputer & Bahasa', 'description' => 'Fasilitas pengembangan skill teknologi informasi dan bahasa Arab/Inggris.'],
            ['name' => 'Perpustakaan Maktabah', 'description' => 'Pusat literatur yang menyediakan ribuan kitab kuning klasik dan buku modern.'],
            ['name' => 'Klinik Kesehatan Santri (Poskestren)', 'description' => 'Fasilitas kesehatan pertolongan pertama dengan tenaga medis siaga.'],
            ['name' => 'Aula Serbaguna', 'description' => 'Gedung pertemuan untuk acara wisuda, seminar, dan perlombaan antar santri.'],
            ['name' => 'Kantin & Koperasi Pondok', 'description' => 'Penyedia kebutuhan harian santri dan sarana latihan kemandirian ekonomi.'],
            ['name' => 'Lapangan Olahraga', 'description' => 'Area terbuka hijau untuk senam, badminton, voli, dan aktivitas fisik lainnya.'],
            ['name' => 'Dapur Umum', 'description' => 'Fasilitas pengolahan makanan higienis untuk pemenuhan gizi seluruh santri.'],
        ];
        foreach ($facilities as $f) {
            Facility::create($f);
        }

        $programs = [
            ['name' => 'Tahfidzul Qur\'an', 'description' => 'Program menghafal Al-Qur\'an 30 Juz dengan sanad bersambung, mutqin, dan evaluasi berkala.'],
            ['name' => 'Kajian Kitab Kuning (Salafiyah)', 'description' => 'Pendalaman ilmu agama (Fiqih, Tauhid, Tasawuf, Nahwu, Shorof) menggunakan kurikulum pesantren salaf murni.'],
            ['name' => 'Madrasah Tsanawiyah (MTs)', 'description' => 'Pendidikan formal tingkat menengah pertama yang mengintegrasikan kurikulum Kemenag dan Kepesantrenan.'],
            ['name' => 'Madrasah Aliyah (MA)', 'description' => 'Pendidikan formal tingkat menengah atas untuk menyiapkan santri menuju perguruan tinggi.'],
            ['name' => 'Kaderisasi Da\'i', 'description' => 'Program khusus pelatihan muhadharah (pidato), kepemimpinan, dan retorika dakwah.'],
            ['name' => 'Pembinaan Bahasa (Muhadatsah)', 'description' => 'Kewajiban berbahasa Arab dan Inggris dalam percakapan sehari-hari di lingkungan asrama.'],
            ['name' => 'Ekstrakurikuler Kaligrafi & Hadrah', 'description' => 'Wadah penyaluran bakat seni Islami melalui latihan kaligrafi (Khat) dan kesenian Hadrah/Rebana.'],
            ['name' => 'Kajian Fiqih Kontemporer (Bahtsul Masail)', 'description' => 'Forum diskusi ilmiah tingkat tinggi untuk memecahkan problematika umat masa kini berdasarkan literatur fiqih.'],
        ];
        foreach ($programs as $p) {
            ClassProgram::create($p);
        }

        $galleryTitles = [
            'Peringatan Maulid Nabi Muhammad SAW', 'Wisuda Tahfidz Angkatan Ke-12', 'Kegiatan Bahtsul Masail Tingkat Provinsi', 
            'Penerimaan Santri Baru 2025', 'Lomba Baca Kitab Kuning', 'Kerja Bakti Lingkungan Pesantren', 
            'Kunjungan Ulama Internasional', 'Pelatihan Jurnalistik Santri', 'Pertandingan Voli Antar Asrama', 
            'Ujian Akhir Semester Madrasah', 'Pembukaan Kegiatan Muharram', 'Penyerahan Beasiswa Santri Berprestasi',
            'Ziarah Makam Muassis', 'Pelatihan Sablon dan Kaligrafi', 'Kegiatan Qurban Idul Adha'
        ];
        foreach ($galleryTitles as $idx => $title) {
            Gallery::create([
                'title' => $title,
                'description' => 'Dokumentasi ' . strtolower($title) . ' yang diselenggarakan di lingkungan Pesantren Darussaadah.',
                'image_url' => 'galleries/sample-' . ($idx + 1) . '.jpg',
            ]);
        }

        $testimonials = [
            ['name' => 'Tgk. H. Ibrahim', 'role' => 'Tokoh Masyarakat', 'message' => 'Pesantren Darussaadah telah banyak melahirkan kader-kader ulama yang bermanfaat bagi umat di seluruh Aceh.'],
            ['name' => 'Abdullah Amin', 'role' => 'Wali Santri', 'message' => 'Alhamdulillah, anak saya mengalami perubahan akhlak yang sangat baik dan kini sudah hafal 15 Juz.'],
            ['name' => 'Fatimah Az-Zahra', 'role' => 'Alumni 2021', 'message' => 'Ilmu alat dan fikih yang saya pelajari di sini menjadi modal utama saya menempuh studi di Al-Azhar, Mesir.'],
            ['name' => 'Dr. Ridwan Rasyid', 'role' => 'Akademisi', 'message' => 'Sistem pendidikan di Darussaadah berhasil memadukan keaslian tradisi salaf dengan kedisiplinan modern.'],
            ['name' => 'Siti Maryam', 'role' => 'Wali Santri', 'message' => 'Fasilitas yang memadai dan lingkungan yang asri membuat anak-anak betah belajar dan jauh dari pengaruh negatif luar.'],
            ['name' => 'Zulkifli Hasan', 'role' => 'Alumni 2018', 'message' => 'Gemblengan kedisiplinan dan kemandirian dari para ustadz membentuk mental kami menjadi kuat dalam menghadapi masyarakat.'],
            ['name' => 'Muhammad Zubair', 'role' => 'Wali Santri', 'message' => 'Sangat mengapresiasi transparansi dan komunikasi yang baik antara pengurus pesantren dengan orang tua santri.'],
            ['name' => 'Ahmad Fauzi', 'role' => 'Santri Aktif', 'message' => 'Metode pembelajaran kitab di sini sangat mudah dipahami. Kami dididik untuk tidak hanya menghafal, tapi memahami intisari.'],
        ];
        foreach ($testimonials as $t) {
            Testimonial::create(array_merge($t, ['is_active' => true]));
        }

        Brochure::create(['title' => 'Brosur PPDB Darussaadah 2026/2027', 'version' => '1.0', 'file_url' => 'brochures/ppdb-2026.pdf']);
        Brochure::create(['title' => 'Profil Lengkap Pesantren', 'version' => '2026', 'file_url' => 'brochures/profil.pdf']);
        Brochure::create(['title' => 'Struktur Kurikulum Salafiyah', 'version' => '1.2', 'file_url' => 'brochures/kurikulum.pdf']);

        $loremParagraphs = "
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
        ";

        $articleTitles = [
            'Pembukaan Tahun Ajaran Baru 2026 Bersama Para Habaib',
            'Prestasi Santri Darussaadah di Lomba Qiroatul Kutub Tingkat Provinsi',
            'Pentingnya Sanad Keilmuan dalam Tradisi Pesantren Salaf',
            'Tips Menghafal Al-Qur\'an dari Mudir Tahfidz',
            'Pembangunan Gedung Asrama Baru Resmi Dimulai',
            'Kajian Rutin Tafsir Jalalain Setiap Ba\'da Subuh',
            'Menggali Makna Filosofis dalam Kitab Al-Hikam',
            'Pesantren Darussaadah Tuan Rumah Bahtsul Masail PWNU Aceh',
            'Program Ekokepesantrenan: Santri Tanam 1000 Pohon',
            'Kunjungan Silaturahmi Kapolda Aceh ke Darussaadah',
            'Jadwal Kepulangan Santri Libur Ramadhan 1447 H',
            'Seminar Jurnalistik dan Literasi Santri Era Digital',
            'Peringatan Haul Pendiri Pesantren Ke-30',
            'Penyuluhan Kesehatan Santri oleh Dinas Kesehatan Pidie',
            'Pelatihan BLK Komunitas: Santri Diajarkan Desain Grafis',
            'Peresmian Laboratorium Bahasa Arab Terpadu',
            'Tata Cara Pendaftaran PPDB Gelombang Kedua',
            'Manfaat Shalat Tahajud Berjamaah bagi Pembentukan Karakter',
            'Ngaji Pasaran Ramadhan Kitab Bidayatul Hidayah',
            'Santri Darussaadah Lolos Seleksi Beasiswa Timur Tengah',
            'Meneladani Akhlak Ulama Salaf di Era Modern',
            'Pembagian Raport Semester Ganjil Madrasah Aliyah'
        ];

        foreach ($articleTitles as $idx => $title) {
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'Menyajikan informasi terbaru dan teraktual mengenai ' . strtolower($title) . ' beserta rincian kegiatannya di Pesantren Darussaadah.',
                'content' => "<h2>" . $title . "</h2>" . $loremParagraphs,
                'is_published' => true,
                'author_id' => ($idx % 2 == 0) ? $admin->id : $editor->id,
                'published_at' => now()->subDays(rand(1, 100))->subHours(rand(1, 24)),
                'cover_image' => 'articles/cover-sample.jpg',
            ]);
        }

        $period = RegistrationPeriod::create([
            'name' => 'Penerimaan Santri Baru TA 2026/2027',
            'start_date' => '2026-01-01',
            'end_date' => '2026-06-30',
            'quota' => 300,
            'registration_fee' => 300000,
            'is_active' => true,
            'form_schema' => [
                ['field_name' => 'nama_ayah', 'label' => 'Nama Lengkap Ayah', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'pekerjaan_ayah', 'label' => 'Pekerjaan Ayah', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'nama_ibu', 'label' => 'Nama Lengkap Ibu', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'asal_sekolah', 'label' => 'Asal Sekolah', 'type' => 'text', 'is_required' => true],
                ['field_name' => 'npsn', 'label' => 'NPSN Sekolah Asal', 'type' => 'text', 'is_required' => false],
                ['field_name' => 'penyakit_bawaan', 'label' => 'Riwayat Penyakit', 'type' => 'textarea', 'is_required' => false],
            ],
            'document_schema' => [
                ['document_key' => 'kk', 'label' => 'Scan Kartu Keluarga Asli', 'is_required' => true],
                ['document_key' => 'akta', 'label' => 'Scan Akta Kelahiran Asli', 'is_required' => true],
                ['document_key' => 'ijazah', 'label' => 'Scan Ijazah / SKL', 'is_required' => true],
                ['document_key' => 'pasfoto', 'label' => 'Pasfoto 3x4 Berwarna', 'is_required' => true],
            ],
        ]);

        $applicants = [
            ['name' => 'Ahmad Fathanah', 'gender' => 'L', 'nik' => '1109010101010001', 'city' => 'Sigli'],
            ['name' => 'Cut Muthia', 'gender' => 'P', 'nik' => '1109010101010002', 'city' => 'Banda Aceh'],
            ['name' => 'Tengku Zulkarnaen', 'gender' => 'L', 'nik' => '1109010101010003', 'city' => 'Bireuen'],
            ['name' => 'Syarifah Aini', 'gender' => 'P', 'nik' => '1109010101010004', 'city' => 'Lhokseumawe'],
            ['name' => 'Muhammad Al-Fatih', 'gender' => 'L', 'nik' => '1109010101010005', 'city' => 'Pidie Jaya'],
            ['name' => 'Zahratus Sittha', 'gender' => 'P', 'nik' => '1109010101010006', 'city' => 'Langsa'],
            ['name' => 'Fakhrurrazi', 'gender' => 'L', 'nik' => '1109010101010007', 'city' => 'Aceh Besar'],
            ['name' => 'Siti Khadijah', 'gender' => 'P', 'nik' => '1109010101010008', 'city' => 'Meulaboh'],
            ['name' => 'Rizki Ramadhan', 'gender' => 'L', 'nik' => '1109010101010009', 'city' => 'Sigli'],
            ['name' => 'Nurul Hidayah', 'gender' => 'P', 'nik' => '1109010101010010', 'city' => 'Banda Aceh'],
            ['name' => 'Irfan Hakim', 'gender' => 'L', 'nik' => '1109010101010011', 'city' => 'Takengon'],
            ['name' => 'Miftahul Jannah', 'gender' => 'P', 'nik' => '1109010101010012', 'city' => 'Bireuen'],
            ['name' => 'Hasan Basri', 'gender' => 'L', 'nik' => '1109010101010013', 'city' => 'Pidie Jaya'],
            ['name' => 'Amina Hanum', 'gender' => 'P', 'nik' => '1109010101010014', 'city' => 'Sigli'],
            ['name' => 'Jamaluddin', 'gender' => 'L', 'nik' => '1109010101010015', 'city' => 'Aceh Utara'],
        ];

        $statuses = ['PENDING', 'VERIFIED', 'REJECTED'];

        foreach ($applicants as $idx => $p) {
            Registration::create([
                'registration_period_id' => $period->id,
                'registration_number' => 'DRS-' . now()->format('ym') . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'full_name' => $p['name'],
                'nik' => $p['nik'],
                'gender' => $p['gender'],
                'place_of_birth' => $p['city'],
                'date_of_birth' => now()->subYears(rand(12, 15))->subDays(rand(1, 300))->format('Y-m-d'),
                'phone_number' => '08' . rand(1000000000, 9999999999),
                'status' => $statuses[array_rand($statuses)],
                'data' => [
                    'nama_ayah' => 'Bapak ' . $p['name'],
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Ibu ' . $p['name'],
                    'asal_sekolah' => 'MIN 1 ' . $p['city'],
                    'npsn' => (string) rand(10000000, 99999999),
                    'penyakit_bawaan' => 'Tidak ada',
                ],
            ]);
        }
    }
}