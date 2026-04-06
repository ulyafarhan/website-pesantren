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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group API Publik Web Pesantren
 *
 * Endpoint utama untuk Frontend. Semua request bersifat publik.
 */
class PublicApiController extends Controller
{
    /**
     * Daftar Artikel
     * * Mengambil berita dan artikel yang sudah diterbitkan.
     */
    public function articles(): JsonResponse
    {
        $articles = Article::with('author:id,name')
            ->where('is_published', true)
            ->latest('published_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    /**
     * Detail Artikel
     * * @urlParam slug string required Slug unik artikel.
     */
    public function articleShow(string $slug): JsonResponse
    {
        $article = Article::with('author:id,name')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $article
        ]);
    }

    /**
     * Galeri Foto
     */
    public function galleries(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Gallery::latest()->get()
        ]);
    }

    /**
     * Fasilitas Pesantren
     */
    public function facilities(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Facility::latest()->get()
        ]);
    }

    /**
     * Program Kelas / Akademik
     */
    public function classPrograms(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ClassProgram::latest()->get()
        ]);
    }

    /**
     * Brosur & Dokumen Unduhan
     */
    public function brochures(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Brochure::latest()->get()
        ]);
    }

    /**
     * Testimonial Alumni/Wali
     */
    public function testimonials(): JsonResponse
    {
        $testimonials = Testimonial::where('is_active', true)->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Pengaturan Website
     * * Mengambil profil, kontak, dan identitas visual pesantren.
     */
    public function siteSettings(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => SiteSetting::first()
        ]);
    }

    /**
     * Periode Pendaftaran Aktif
     * * Mengambil informasi gelombang pendaftaran yang sedang dibuka beserta skema formnya.
     */
    public function activeRegistrationPeriod(): JsonResponse
    {
        $period = RegistrationPeriod::where('is_active', true)->first();

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
     * * Mengirim data pendaftaran santri baru secara dinamis.
     * * @bodyParam full_name string required Nama lengkap santri.
     * @bodyParam data object Data tambahan sesuai form_schema gelombang.
     * @bodyParam documents file[] Berkas ungguhan sesuai document_schema.
     */
    public function postRegister(Request $request): JsonResponse
    {
        $period = RegistrationPeriod::where('is_active', true)->first();

        if (!$period) {
            return response()->json(['success' => false, 'message' => 'Maaf, pendaftaran sudah ditutup.'], 404);
        }

        // 1. Bangun Aturan Validasi secara Dinamis
        $rules = [
            'full_name' => 'required|string|max:255',
        ];

        // Validasi isian form (JSON data)
        if ($period->form_schema) {
            foreach ($period->form_schema as $field) {
                $rule = match($field['type']) {
                    'number' => 'numeric',
                    'date'   => 'date',
                    default  => 'string',
                };
                
                if ($field['is_required'] ?? false) {
                    $rule .= '|required';
                }
                $rules['data.' . $field['field_name']] = $rule;
            }
        }

        // Validasi berkas (JSON documents)
        if ($period->document_schema) {
            foreach ($period->document_schema as $doc) {
                $docRule = 'file|mimes:pdf,jpg,jpeg,png|max:2048'; // Max 2MB
                if ($doc['is_required'] ?? false) {
                    $docRule .= '|required';
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
                // Simpan ke folder public/registrations/{period_id}
                $path = $file->store("registrations/{$period->id}", 'public');
                $documentPaths[$key] = $path;
            }
        }

        // 3. Simpan Data Pendaftaran
        $registration = Registration::create([
            'registration_period_id' => $period->id,
            'registration_number' => 'REG-' . now()->format('Ymd') . strtoupper(Str::random(4)),
            'full_name' => $request->full_name,
            'data' => $request->data, // Otomatis dicasting ke JSON oleh Model
            'documents' => $documentPaths,
            'status' => 'PENDING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dikirim. Harap simpan Nomor Pendaftaran Anda.',
            'registration_number' => $registration->registration_number
        ], 201);
    }
}