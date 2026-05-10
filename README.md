# DOKUMENTASI SISTEM WEBSITE PESANTREN & PPDB ONLINE

## 1. Deskripsi Sistem
Sistem ini merupakan platform portal informasi dan sistem Penerimaan Peserta Didik Baru (PPDB) terpadu yang dirancang khusus untuk entitas lembaga pendidikan atau pondok pesantren. Aplikasi ini mengkombinasikan fungsionalitas Web Profile (sebagai media informasi publik) dengan Web Portal terstruktur (sebagai pusat manajemen pendaftaran santri dan integrasi API publik).

Sistem dikembangkan menggunakan arsitektur *Monolithic* dengan dukungan *Server-Side Rendering* (SSR) untuk antarmuka publik guna mengoptimalkan indeksasi mesin pencari (SEO), serta arsitektur berbasis *TALL Stack / Livewire* untuk area dasbor tata kelola (Admin Panel).

## 2. Arsitektur dan Teknologi
Aplikasi dibangun di atas infrastruktur modern dengan spesifikasi sebagai berikut:
* **Core Framework:** Laravel (PHP) 12
* **Admin Panel / CMS:** Filament PHP v5 (berbasis Livewire dan Alpine.js)
* **Frontend UI:** Laravel Blade templating dipadukan dengan Tailwind CSS v4
* **Frontend Build Tool:** Vite
* **API Documentation:** Scribe (Dokumentasi API terotomatisasi)
* **Caching & Performa:** Sistem *Full Page Cache* berbasis arsitektur *middleware* kustom untuk mempercepat waktu muat halaman publik.
* **Development Environment:** Laravel Sail (Docker) terintegrasi untuk standarisasi pengembangan (PHP 8.0 - 8.5 images support).

## 3. Fitur Utama yang Tersedia
Berdasarkan struktur kode pada repositori, sistem telah dilengkapi dengan modul-modul berikut:

### A. Modul Tata Kelola (Filament Admin Panel)
Admin memiliki akses penuh ke dalam *dashboard* untuk mengelola data melalui *Resources* berikut:
1.  **Manajemen Artikel (Articles):** Pengelolaan publikasi berita, blog, dan pengumuman sekolah terintegrasi dengan *rich-text editor*.
2.  **Manajemen Fasilitas (Facilities):** Pendataan dan publikasi sarana dan prasarana pesantren.
3.  **Manajemen Program Kelas (Class Programs):** Konfigurasi penawaran kurikulum atau jenjang pendidikan yang tersedia.
4.  **Manajemen Galeri (Galleries) & Brosur (Brochures):** Pusat media visual dan dokumen publikasi PDF/Brosur pesantren.
5.  **Manajemen Testimoni (Testimonials):** Pengelolaan ulasan dari wali santri atau alumni.
6.  **Manajemen PPDB (Registrations & Registration Periods):** * Pembuatan gelombang/periode pendaftaran secara dinamis dengan rentang waktu spesifik.
    * Pemantauan dan pengelolaan data pendaftar calon santri baru secara terpusat.
7.  **Manajemen Pengaturan Situs (Site Settings):** Konfigurasi global sistem (seperti Nama Pesantren, Logo, URL Sosial Media, Kontak) yang bersifat dinamis tanpa perlu mengubah *source code*.

### B. Modul Frontend (Akses Publik)
Antarmuka publik dirancang secara modular (*Component-based Blade*), meliputi:
* Halaman Beranda (*Hero section, statistik, sekilas info*).
* Halaman Tentang Kami & Fasilitas.
* Halaman Program Akademik.
* Halaman Publikasi (Indeks Artikel dan Detail Artikel).
* Halaman Pendaftaran PPDB terintegrasi formulir pendaftaran interaktif.
* Halaman Pengecekan Status Pendaftaran (Check Status).

### C. Modul API Publik (REST API)
Sistem memaparkan *endpoints* API (dikelola oleh `PublicApiController`) yang berguna untuk diintegrasikan dengan sistem eksternal atau aplikasi *mobile*. Seluruh rute API terdokumentasi dengan baik menggunakan pustaka Scribe yang dapat diakses melalui rute `/docs` atau antarmuka spesifik.

## 4. Bagaimana Sistem Bekerja (Alur Sistem)

1.  **Alur Kunjungan Publik:**
    Pengunjung mengakses situs melalui URL utama. *Router* meneruskan permintaan ke `PublicController`. Sistem akan mengecek apakah halaman tersebut memiliki *cache* (*FullPageCache Middleware*). Jika ada, halaman langsung disajikan untuk performa maksimal. Jika tidak, data ditarik dari *database*, di-*render* oleh Blade HTML, di-*cache*, dan dikirim ke pengguna.
2.  **Alur Pendaftaran Santri (PPDB):**
    * Administrator membuka periode pendaftaran melalui halaman Admin (*Registration Periods*).
    * Calon santri mengunjungi halaman `/ppdb/register` dan mengisi data diri.
    * Sistem memvalidasi formulir dan mencatat entri ke tabel `registrations`.
    * Calon santri menerima kode pelacakan/registrasi dan diarahkan ke halaman sukses.
    * Calon santri dapat memantau status kelulusan pada halaman `/ppdb/check-status`.
3.  **Alur Sinkronisasi Data (Observers):**
    Setiap kali Administrator menambah, mengubah, atau menghapus data utama (seperti Artikel, Fasilitas, atau Pengaturan Situs), sistem *Observer* (misal: `ArticleObserver`, `SiteSettingObserver`) akan terpicu secara otomatis. *Observer* ini bertugas untuk membersihkan *cache* halaman publik (via *command* `ClearPublicCache`) agar pengunjung selalu mendapatkan data paling mutakhir tanpa perlu pembersihan *cache* manual.

## 5. Panduan Instalasi dan Konfigurasi Lokal

**Prasyarat Minimum:**
* PHP ^8.3
* Composer
* Node.js & NPM
* Database (MySQL / PostgreSQL)

**Langkah Instalasi:**
1. Kloning repositori:
   `git clone <repository_url>`
2. Salin konfigurasi environment:
   `cp .env.example .env`
3. Sesuaikan konfigurasi koneksi database pada fail `.env`.
4. Instalasi dependensi sisi backend:
   `composer install`
5. Bangkitkan *Application Key*:
   `php artisan key:generate`
6. Jalankan migrasi beserta *Seeder* (untuk menginisiasi data *dummy* dan akun *admin*):
   `php artisan migrate --seed`
7. Buat tautan simbolis penyimpanan file media:
   `php artisan storage:link`
8. Instalasi dan kompilasi dependensi antarmuka:
   `npm install && npm run build`
9. Eksekusi peladen lokal:
   `php artisan serve`

*Catatan: Anda juga dapat menggunakan perintah `chmod +x deploy.sh && ./deploy.sh` jika berada dalam lingkungan server Linux/Unix.*

## 6. Rencana Pengembangan Berikutnya (Roadmap)

Untuk ekspansi skalabilitas sistem dan peningkatan kapabilitas jangka panjang, perbaikan dan fitur berikut sangat direkomendasikan untuk pengembangan iterasi selanjutnya:

1.  **Integrasi Gateway Pembayaran (Payment Gateway):**
    Mengotomatisasi verifikasi biaya pendaftaran PPDB. Integrasi dengan penyedia layanan seperti Midtrans atau Xendit agar admin tidak perlu melakukan verifikasi pembayaran secara manual.
2.  **Sistem Notifikasi Push (WhatsApp & Email Gateway):**
    Menambahkan fungsionalitas pengiriman pesan instan (misal menggunakan API WhatsApp/SMTP Email) kepada calon santri setiap kali status pendaftaran mereka diperbarui (Contoh: Diterima / Menunggu Verifikasi).
3.  **Modul Sistem Informasi Akademik Dasar (SIAKAD):**
    Eksplorasi penambahan modul tata kelola santri aktif, yang mencakup manajemen data nilai (e-Rapor), jadwal absensi, dan pelanggaran, guna menyempurnakan transisi data dari pendaftar menjadi santri aktif.
4.  **Lokalisasi dan Internasionalisasi (Multi-bahasa):**
    Memperluas capaian dengan menerapkan dukungan dwibahasa (misal: Bahasa Indonesia dan Bahasa Arab/Inggris) pada antarmuka *frontend*.
5.  **Penguatan Metrik Analitik Admin:**
    Meningkatkan kompleksitas *Widgets* pada Dasbor Filament dengan menambahkan grafik pendaftaran santri baru (*conversion chart*) berdasarkan gelombang pendaftaran secara *real-time*.
