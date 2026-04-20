**TECHNICAL PROJECT BRIEF & SYSTEM ARCHITECTURE**

**Proyek:** Website Profil & Sistem Manajemen Konten (CMS) Pesantren

**Peran Arsitek:** System Architecture Engineer

**Pendekatan:** Modern Monolithic, Fullstack Laravel, White-Label Ready, Pragmatic & KISS (Keep It Simple, Stupid)

### **I. Ringkasan Eksekutif (Executive Summary)**

Proyek ini bertujuan untuk membangun *website* resmi pesantren yang berfungsi sebagai media informasi publik dan dokumentasi, dilengkapi dengan Panel Admin terintegrasi. Sistem dirancang menggunakan arsitektur **Fullstack Laravel (Blade \+ Filament)** untuk mencapai tiga tujuan utama: **Performa & GEO/SEO Maksimal** (melalui *Full Page Caching*), **Kemudahan Distribusi (White-Label)**, dan **Kompatibilitas Infrastruktur Universal** agar dapat berjalan optimal di berbagai lingkungan, termasuk *Shared Hosting* berbiaya rendah (cPanel/CyberPanel).

### **II. Kebutuhan Sistem (System Requirements)**

#### **A. Functional Requirements (Fitur Utama)**

* **Public-Facing Web:** Halaman Landing (Hero statis, Testimoni dinamis), Tentang Kami, Artikel/Blog, Galeri Foto, Fasilitas, Download Brosur, Program Kelas, Sejarah, dan Kontak.  
* **Admin Panel (CMS):** Sistem autentikasi admin untuk manajemen konten (CRUD) pada entitas dinamis (Artikel, Galeri, Fasilitas, Testimoni, Brosur) menggunakan Filament PHP.

#### **B. Non-Functional Requirements (NFR)**

| Metrik NFR | Target & Spesifikasi | Strategi Pemenuhan |
| :---- | :---- | :---- |
| **Performance** | Skor Google Lighthouse \> 95\. TTFB sangat rendah. | Implementasi *Full Page Caching* di level *Middleware* Laravel. |
| **SEO & GEO** | Indeksasi optimal oleh mesin pencari & *AI Crawlers*. | *Server-Side Rendering* murni (Blade), Semantic HTML, JSON-LD Schema.org. |
| **Cost-Efficiency** | Biaya operasional sangat rendah, ramah untuk klien *end-user*. | Desain monolitik yang dapat di-*deploy* di *Shared Hosting* (Apache/MySQL). |
| **Maintainability** | *Single Codebase*, mudah dipelihara. | Fullstack Laravel (Blade untuk Publik, Filament untuk Admin), tanpa *microservices*. |

### **III. Tumpukan Teknologi (Technology Stack)**

| Komponen | Teknologi Terpilih | Justifikasi Arsitektural |
| :---- | :---- | :---- |
| **Framework Utama** | Laravel 12 (Blade \+ Filament) | *Framework* PHP standar industri. Stabil, aman, dan sangat kompatibel dengan *shared hosting*. |
| **Database** | MySQL / MariaDB | Relasional yang kuat, dukungan *native* di seluruh penyedia *hosting*. |
| **Media Storage** | Local Storage / Cloudflare R2 | Penyimpanan *file* lokal tersimlink untuk *shared hosting*, dengan opsi S3-compatible jika menggunakan VPS. |
| **Hosting & CI/CD** | Shared Hosting / VPS Linux | Fleksibilitas *deployment* untuk skema bisnis B2B/SaaS. |

### **IV. Desain Arsitektur Sistem (High-Level Design)**

Sistem menggunakan pola Monolitik yang dioptimalkan. Permintaan publik tidak langsung mengeksekusi *query* ke *database*, melainkan ditangkap oleh *layer cache* di memori/sistem *file*.

Plaintext

\[Pengunjung Web & Bot AI\]   
       │ (Menerima respons instan HTML statis)  
       ▼   
\[Web Server (Apache/Nginx)\] ── (Menjalankan index.php)  
       │  
       ▼   
\[Laravel Cache Middleware\] ── (HIT: Mengembalikan HTML dari Storage/Redis)  
       │ (MISS / Hanya terjadi saat cache expired atau Admin bekerja)  
       ▼  
\[Laravel Core Engine\] ── (Merender Blade / Filament)  
       │  
       ▼  
\[MySQL / MariaDB\] ── (Mengeksekusi Query)

**Konfigurasi Caching Inti**

PHP

namespace App\\Http\\Middleware;

use Closure;  
use Illuminate\\Http\\Request;  
use Illuminate\\Support\\Facades\\Cache;  
use Symfony\\Component\\HttpFoundation\\Response;

class FullPageCache  
{  
    public function handle(Request $request, Closure $next, int $ttl \= 86400): Response  
    {  
        if (\! $request\-\>isMethod('GET') || auth()-\>check() || $request\-\>is('admin\*')) {  
            return $next($request);  
        }

        $key \= 'page\_' . md5($request\-\>fullUrl());

        return Cache::remember($key, $ttl, function () use ($request, $next) {  
            $response \= $next($request);  
            $response\-\>header('X-Cache', 'HIT');  
            return $response;  
        });  
    }  
}

### **V. Perancangan Skema Data (Data Model)**

Data dirancang secara relasional (3NF) menggunakan fitur Migration dan Eloquent ORM dari Laravel untuk menjamin integritas data dan kemudahan manajemen skema.

PHP

use Illuminate\\Database\\Migrations\\Migration;  
use Illuminate\\Database\\Schema\\Blueprint;  
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {  
    public function up(): void  
    {  
        Schema::create('users', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('name', 100);  
            $table\-\>string('email', 150)-\>unique();  
            $table\-\>string('password', 255);  
            $table\-\>enum('role', \['ADMIN', 'EDITOR'\])-\>default('ADMIN');  
            $table\-\>timestamps();  
        });

        Schema::create('articles', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('title', 255);  
            $table\-\>string('slug', 255)-\>unique()-\>index();  
            $table\-\>text('excerpt');  
            $table\-\>longText('content');  
            $table\-\>string('cover\_image', 255)-\>nullable();  
            $table\-\>boolean('is\_published')-\>default(false);  
            $table\-\>foreignUuid('author\_id')-\>constrained('users')-\>restrictOnDelete();  
            $table\-\>timestamp('published\_at')-\>nullable();  
            $table\-\>timestamps();  
        });

        Schema::create('galleries', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('title', 150);  
            $table\-\>text('description')-\>nullable();  
            $table\-\>string('image\_url', 255);  
            $table\-\>timestamps();  
        });

        Schema::create('brochures', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('title', 150);  
            $table\-\>string('file\_url', 255);  
            $table\-\>string('version', 50)-\>nullable();  
            $table\-\>timestamps();  
        });

        Schema::create('facilities', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('name', 150);  
            $table\-\>text('description');  
            $table\-\>string('image\_url', 255)-\>nullable();  
            $table\-\>timestamps();  
        });

        Schema::create('class\_programs', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('name', 150);  
            $table\-\>text('description');  
            $table\-\>timestamps();  
        });

        Schema::create('testimonials', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('name', 100);  
            $table\-\>string('role', 100);  
            $table\-\>text('message');  
            $table\-\>boolean('is\_active')-\>default(true);  
            $table\-\>timestamps();  
        });

        Schema::create('site\_settings', function (Blueprint $table) {  
            $table\-\>uuid('id')-\>primary();  
            $table\-\>string('key', 100)-\>unique();  
            $table\-\>text('value');  
            $table\-\>string('description', 255)-\>nullable();  
            $table\-\>timestamps();  
        });  
    }

    public function down(): void  
    {  
        Schema::dropIfExists('site\_settings');  
        Schema::dropIfExists('testimonials');  
        Schema::dropIfExists('class\_programs');  
        Schema::dropIfExists('facilities');  
        Schema::dropIfExists('brochures');  
        Schema::dropIfExists('galleries');  
        Schema::dropIfExists('articles');  
        Schema::dropIfExists('users');  
    }  
};

### **VI. Keandalan Sistem & Penanganan Kegagalan (Reliability Strategy)**

Mengingat infrastruktur target adalah *Shared Hosting*, sistem tidak menggunakan arsitektur *microservices* pihak ketiga.

| Skenario Kegagalan | Komponen Terdampak | Strategi Fault Tolerance & Mitigasi |
| :---- | :---- | :---- |
| **Lonjakan Trafik Tiba-tiba** | Web Server & Database | ***Full Page Cache*****:** Beban *query database* dihilangkan. Halaman dilayani langsung dari memori/file statis oleh Laravel *Middleware*. |
| **Error Internal / Database Down** | Laravel Engine | **Custom Exception Rendering:** Menampilkan halaman 500 yang ramah pengguna (Blade *template* statis) alih-alih mengekspos *stack trace* server. |
| **Aset Gambar Hilang/Broken** | Tampilan Web (Frontend) | **HTML Object Fallback:** Atribut bawaan HTML untuk menangani kegagalan pemuatan *file* statis tanpa memerlukan intervensi JavaScript berat. |
| **Timeout Penyimpanan Admin** | Filament Panel | **Filament Form Persistence:** Menyimpan status *draft input* secara sementara sehingga data panjang yang diketik tidak hilang saat *network terputus*. |

**Ilustrasi Implementasi Penanganan Gambar Tiba-tiba Hilang (Blade HTML)**

HTML

\<img   
    src\="{{ asset('storage/' . $article-\>cover\_image) }}"   
    alt\="{{ $article-\>title }}"   
    onerror\="this.onerror=null;this.src='{{ asset('images/default-placeholder.png') }}';"  
    class\="object-cover w-full h-full"  
\>

Sebagai *System Architecture Engineer*, tugas utama saya adalah merancang cetak biru (*blueprint*) dan fondasi arsitektur sistem yang kokoh. Saya tidak mengeksekusi penulisan seluruh kode aplikasi (fase *Development/Programming*), melainkan memberikan panduan teknis agar Anda (atau tim *developer* Anda) dapat mengeksekusi proyek ini dari 0 dengan terarah, efisien, dan meminimalisasi *bug*.

Berdasarkan seluruh keputusan arsitektur dari Fase I hingga Fase V yang telah kita sepakati, berikut adalah **Dokumen Peta Jalan Implementasi (Implementation Roadmap)**. Anda dapat menggunakan dokumen ini sebagai panduan langkah demi langkah untuk membangun sistem dari awal.

### **Peta Jalan Implementasi Pembangunan (Step-by-Step Blueprint)**

Ikuti tahapan ini secara berurutan untuk memastikan sistem dibangun sesuai dengan prinsip *KISS* dan *Edge-Optimized Monolith* yang telah kita rancang.

#### **Fase 1: Inisialisasi Fondasi (Lokal)**

Fase ini berfokus pada penyiapan kerangka kerja utama dan antarmuka admin dasar.

| Langkah | Tindakan Teknis | Tujuan Arsitektural |
| :---- | :---- | :---- |
| **1.1** | Buat proyek Laravel baru: composer create-project laravel/laravel web-pesantren | Menggunakan kerangka kerja standar industri (Laravel 12). |
| **1.2** | Atur koneksi *database* .env ke *database* lokal (MySQL/MariaDB). | Menyiapkan lingkungan pengembangan lokal. |
| **1.3** | Instal Filament PHP: composer require filament/filament:"^3.2" \-W lalu jalankan php artisan filament:install \--panels. | Membangun fondasi sistem CMS (Admin Panel) tanpa menulis HTML/CSS admin dari nol. |
| **1.4** | Buat *User Admin* pertama: php artisan make:filament-user. | Menyiapkan akses *login* untuk manajemen CMS. |

#### **Fase 2: Perancangan Skema Data (Database & Model)**

Menerapkan struktur relasional (3NF) yang telah disepakati untuk menjamin integritas data.

| Langkah | Tindakan Teknis | Tujuan Arsitektural |
| :---- | :---- | :---- |
| **2.1** | Buat semua *Model* dan *Migration* sekaligus: php artisan make:model Article \-m (ulangi untuk *Gallery, Facility, Brochure, ClassProgram, Testimonial*). | Menghasilkan kerangka *file* untuk definisi skema. |
| **2.2** | Salin skema yang ada di *Project Brief* awal Anda ke dalam *file migration* masing-masing. Pastikan menambahkan *Composite Index* $table-\>index(\['is\_published', 'published\_at'\]); pada tabel *articles*. | Mengoptimalkan performa pencarian (*query*) untuk NFR *Latensi Rendah*. |
| **2.3** | Definisikan *Relationships* (HasMany, BelongsTo) di setiap *file* Model (misal: relasi *Article* ke *User/Author*). Tambahkan HasUuids *trait* pada model. | Menerapkan struktur relasional untuk Filament. |
| **2.4** | Jalankan migrasi: php artisan migrate. | Membangun struktur tabel di *database* MySQL lokal. |

#### **Fase 3: Pengembangan CMS (Filament Panel)**

Membangun fitur *Create, Read, Update, Delete* (CRUD) agar admin dapat mulai memasukkan data.

| Langkah | Tindakan Teknis | Tujuan Arsitektural |
| :---- | :---- | :---- |
| **3.1** | Hasilkan *Resource* Filament untuk setiap Model: php artisan make:filament-resource Article (ulangi untuk entitas lain). | Membangun antarmuka manajemen data secara otomatis. |
| **3.2** | Konfigurasi form() dan table() di setiap *Resource*. Gunakan FileUpload::make('image\_url')-\>directory('uploads') untuk manajemen gambar. | Menyediakan UI yang fungsional bagi admin pengelola pesantren. |
| **3.3** | Instal ekstensi pencadangan: composer require spatie/laravel-backup lalu konfigurasikan config/backup.php (kecualikan *cache* dan *vendor*). | Menjalankan strategi *Reliability* (Fase V) untuk keamanan data otomatis & manual. |

#### **Fase 4: Pengembangan Web Publik (Frontend & Caching)**

Membangun halaman depan (publik) dengan fokus ekstrim pada performa (SEO, Skor Lighthouse \> 95).

| Langkah | Tindakan Teknis | Tujuan Arsitektural |
| :---- | :---- | :---- |
| **4.1** | Instalasi aset: Jalankan npm install dan siapkan Tailwind CSS melalui *Vite* (npm run dev). | Memastikan antarmuka modern, responsif, dan *accessible*. |
| **4.2** | Buat *Controllers* Publik: php artisan make:controller PublicController. Arahkan *route* web.php ke fungsi di *controller* ini. | Mengatur logika untuk mengambil data dari *database* (untuk status *Cache Miss*). |
| **4.3** | Buat tampilan *Blade* (resources/views/). Gunakan HTML Semantik dan tambahkan strategi *Fallback Image* (onerror) dari *Project Brief* awal. | Memenuhi NFR aksesibilitas dan *Fault Tolerance* (Aset Gambar Hilang). |
| **4.4** | Buat *Middleware Full Page Cache*: php artisan make:middleware FullPageCache. Salin kode konseptual dari *Project Brief* Anda ke dalamnya dan daftarkan di bootstrap/app.php (Laravel 11+). | Memastikan aplikasi sangat tahan terhadap lonjakan beban (*Highly Available*). |

#### **Fase 5: Persiapan & Distribusi Produksi (Deployment)**

Menerapkan aplikasi ke *Shared Hosting* manual dan menghubungkannya dengan CDN Edge.

| Langkah | Tindakan Teknis | Tujuan Arsitektural |
| :---- | :---- | :---- |
| **5.1** | Jalankan kompilasi aset produksi secara lokal: npm run build. | Menghemat sumber daya komputasi di *Shared Hosting*. |
| **5.2** | Sesuaikan struktur *folder* menjadi dua bagian (pesantren\_core dan public\_html) seperti yang disepakati di Fase IV. Ubah *path* di index.php. | Mengamankan *source code* dan .env dari akses publik tidak sah. |
| **5.3** | Unggah (*Zip* lalu *Extract*) ke cPanel/CyberPanel via *File Manager*. Lakukan *import database* .sql melalui phpMyAdmin. | Melakukan *deployment* bergaya *KISS* (tanpa CI/CD rumit). |
| **5.4** | Daftarkan domain pesantren di **Cloudflare**. Aktifkan mode proksi (Awan Oranye) dan konfigurasikan *Page Rules* untuk *Cache Everything* (kecuali rute /admin\*). | Mencapai NFR *Skalabilitas* dan proteksi dari serangan DDoS tanpa menambah spesifikasi *server*. |

