<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Brochure;
use App\Models\ClassProgram;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group API Publik Web Pesantren
 *
 * Endpoint utama untuk Frontend. Semua request bersifat publik.
 * Rate limit: 60 request/menit (GET), 5 request/menit (POST register).
 */
class PublicApiController extends Controller
{
    /**
     * Daftar Artikel
     * 
     * Mengambil berita dan artikel yang sudah diterbitkan.
     * Response di-cache selama 1 jam.
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "title": "Judul", "slug": "judul", "excerpt": "...", "published_at": "2026-01-01T00:00:00Z"}]}
     */
    public function articles(): JsonResponse
    {
        $articles = Cache::remember('api_articles', now()->addHours(1), fn () =>
            Article::with('author:id,name')
                ->select('id', 'title', 'slug', 'cover_image', 'excerpt', 'published_at', 'author_id')
                ->where('is_published', true)
                ->latest('published_at')
                ->get()
        );

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    /**
     * Detail Artikel
     * 
     * Mengambil konten lengkap sebuah artikel berdasarkan slug.
     * Response di-cache selama 1 jam per-slug.
     *
     * @urlParam slug string required Slug unik artikel. Example: sejarah-pesantren
     * @response 200 {"success": true, "data": {"id": "uuid", "title": "Judul", "content": "..."}}
     * @response 404 {"message": "Not Found"}
     */
    public function articleShow(string $slug): JsonResponse
    {
        $article = Cache::remember("api_article_{$slug}", now()->addHours(1), fn () =>
            Article::with('author:id,name')
                ->where('slug', $slug)
                ->where('is_published', true)
                ->first()
        );

        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $article
        ]);
    }

    /**
     * Galeri Foto
     * 
     * Mengambil seluruh galeri foto pesantren.
     * Response di-cache selama 12 jam.
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "title": "Judul", "image_url": "path"}]}
     */
    public function galleries(): JsonResponse
    {
        $galleries = Cache::remember('api_galleries', now()->addHours(12), fn () =>
            Gallery::select('id', 'title', 'description', 'image_url')->latest()->get()
        );

        return response()->json([
            'success' => true,
            'data' => $galleries
        ]);
    }

    /**
     * Fasilitas Pesantren
     * 
     * Mengambil daftar fasilitas yang tersedia.
     * Response di-cache selama 12 jam.
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "name": "Masjid", "description": "..."}]}
     */
    public function facilities(): JsonResponse
    {
        $facilities = Cache::remember('api_facilities', now()->addHours(12), fn () =>
            Facility::select('id', 'name', 'description', 'image_url')->latest()->get()
        );

        return response()->json([
            'success' => true,
            'data' => $facilities
        ]);
    }

    /**
     * Program Kelas / Akademik
     * 
     * Mengambil daftar program kelas pesantren.
     * Response di-cache secara permanen (invalidated oleh admin saat update).
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "name": "Tahfidz", "description": "..."}]}
     */
    public function classPrograms(): JsonResponse
    {
        $programs = Cache::rememberForever('api_class_programs', fn () =>
            ClassProgram::select('id', 'name', 'description')->latest()->get()
        );

        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }

    /**
     * Brosur & Dokumen Unduhan
     * 
     * Mengambil daftar brosur dan file unduhan.
     * Response di-cache selama 12 jam.
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "title": "Brosur 2026", "file_url": "path"}]}
     */
    public function brochures(): JsonResponse
    {
        $brochures = Cache::remember('api_brochures', now()->addHours(12), fn () =>
            Brochure::select('id', 'title', 'file_url', 'version')->latest()->get()
        );

        return response()->json([
            'success' => true,
            'data' => $brochures
        ]);
    }

    /**
     * Testimonial Alumni/Wali
     * 
     * Mengambil testimonial yang aktif.
     * Response di-cache selama 12 jam.
     *
     * @response 200 {"success": true, "data": [{"id": "uuid", "name": "Ahmad", "role": "Alumni", "message": "..."}]}
     */
    public function testimonials(): JsonResponse
    {
        $testimonials = Cache::remember('api_testimonials', now()->addHours(12), fn () =>
            Testimonial::select('id', 'name', 'role', 'message')
                ->where('is_active', true)
                ->latest()
                ->get()
        );

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Pengaturan Website
     * 
     * Mengambil profil, kontak, dan identitas visual pesantren.
     * Response di-cache secara permanen (invalidated oleh admin saat update).
     *
     * @response 200 {"success": true, "data": {"site_name": "Pesantren", "email": "info@pesantren.id"}}
     */
    public function siteSettings(): JsonResponse
    {
        $settings = Cache::rememberForever('api_site_settings', fn () =>
            SiteSetting::first()
        );

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Periode Pendaftaran Aktif
     * 
     * Mengambil informasi gelombang pendaftaran yang sedang dibuka beserta skema formnya.
     * Response di-cache selama 1 jam.
     *
     * @response 200 {"success": true, "data": {"id": "uuid", "name": "Gelombang 1", "is_active": true}}
     * @response 404 {"success": false, "message": "Pendaftaran sedang ditutup."}
     */
    public function activeRegistrationPeriod(): JsonResponse
    {
        $period = Cache::remember('api_active_period', now()->addHours(1), fn () =>
            RegistrationPeriod::where('is_active', true)->first()
        );

        if (!$period) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran sedang ditutup.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $period
        ]);
    }

    /**
     * Kirim Pendaftaran (PPDB)
     * 
     * Mengirim data pendaftaran santri baru secara dinamis.
     * Rate limit: 5 request per menit.
     *
     * @bodyParam full_name string required Nama lengkap santri. Example: Muhammad Ulya Farhan
     * @bodyParam nik string required NIK 16 digit. Example: 1234567890123456
     * @bodyParam gender string required Jenis kelamin (L/P). Example: L
     * @bodyParam place_of_birth string required Tempat lahir. Example: Sigli
     * @bodyParam date_of_birth date required Tanggal lahir (YYYY-MM-DD). Example: 2010-05-15
     * @bodyParam phone_number string required Nomor WA orang tua. Example: 08123456789
     * @bodyParam data object Data tambahan sesuai form_schema gelombang.
     * @bodyParam documents file[] Berkas unggahan sesuai document_schema (JPG/PNG/PDF, maks 2MB).
     *
     * @response 201 {"success": true, "message": "Pendaftaran berhasil dikirim.", "registration_number": "REG-20260419ABCD"}
     * @response 404 {"success": false, "message": "Maaf, pendaftaran sudah ditutup."}
     * @response 422 {"success": false, "errors": {"full_name": ["Nama wajib diisi."]}}
     */
    public function postRegister(Request $request): JsonResponse
    {
        $period = RegistrationPeriod::where('is_active', true)->first();

        if (!$period) {
            return response()->json(['success' => false, 'message' => 'Maaf, pendaftaran sudah ditutup.'], 404);
        }

        // 1. Bangun Aturan Validasi — termasuk semua field identitas inti
        $rules = [
            'full_name'      => 'required|string|max:255',
            'nik'            => 'required|string|size:16',
            'gender'         => 'required|in:L,P',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth'  => 'required|date|before:today',
            'phone_number'   => 'required|string|max:20',
        ];

        // Validasi isian form dinamis (JSON data)
        if ($period->form_schema) {
            foreach ($period->form_schema as $field) {
                $rule = match($field['type']) {
                    'number' => 'numeric',
                    'date'   => 'date',
                    default  => 'string|max:500',
                };
                
                if ($field['is_required'] ?? false) {
                    $rule = 'required|' . $rule;
                } else {
                    $rule = 'nullable|' . $rule;
                }
                $rules['data.' . $field['field_name']] = $rule;
            }
        }

        // Validasi berkas (JSON documents)
        if ($period->document_schema) {
            foreach ($period->document_schema as $doc) {
                $docRule = 'file|mimes:pdf,jpg,jpeg,png|max:2048';
                if ($doc['is_required'] ?? false) {
                    $docRule = 'required|' . $docRule;
                } else {
                    $docRule = 'nullable|' . $docRule;
                }
                $rules['documents.' . $doc['document_key']] = $docRule;
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Proses Upload Berkas
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store("registrations/{$period->id}", 'public');
                $documentPaths[$key] = $path;
            }
        }

        // 3. Simpan Data Pendaftaran — semua field identitas inti tersimpan
        $registration = Registration::create([
            'registration_period_id' => $period->id,
            'registration_number'    => 'REG-' . now()->format('Ymd') . strtoupper(Str::random(4)),
            'full_name'              => $request->full_name,
            'nik'                    => $request->nik,
            'gender'                 => $request->gender,
            'place_of_birth'         => $request->place_of_birth,
            'date_of_birth'          => $request->date_of_birth,
            'phone_number'           => $request->phone_number,
            'data'                   => $request->data ?? [],
            'documents'              => $documentPaths,
            'status'                 => 'PENDING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dikirim. Harap simpan Nomor Pendaftaran Anda.',
            'registration_number' => $registration->registration_number
        ], 201);
    }
}