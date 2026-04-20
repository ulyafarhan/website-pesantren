# Sistem Informasi & CMS Pesantren Darussa'adah

Sistem Informasi Web dan Content Management System (CMS) terintegrasi, dibangun dengan pendekatan Modern Monolithic untuk pengelolaan informasi publik dan administrasi internal pesantren.

## Arsitektur & Teknologi

- **Framework:** Laravel 12
- **Frontend:** Blade Components, Tailwind CSS, Alpine.js, Swup (SPA Transitions)
- **Backend/Panel Admin:** Filament PHP v5
- **Optimasi:** Full Page Caching (Middleware), Open Image CDN (wsrv.nl), Eager Loading (N+1 Prevention)

## Fitur Utama

- **Portal Publik:** Menampilkan profil pesantren, artikel, galeri, fasilitas, dan program pendidikan.
- **PPDB Online:** Sistem pendaftaran santri baru secara digital.
- **CMS Admin:** Pengelolaan seluruh entitas data melalui antarmuka Filament yang responsif.

## Instalasi & Deployment

1. `git clone [url-repositori]`
2. `composer install` & `npm install`
3. Salin `.env.example` ke `.env` lalu sesuaikan kredensial basis data.
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan storage:link`
7. `npm run build`
8. `php artisan serve`