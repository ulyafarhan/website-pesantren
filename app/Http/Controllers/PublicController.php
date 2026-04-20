<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\ClassProgram;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\RegistrationPeriod;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublicController extends Controller
{
    private function getSettings(): SiteSetting
    {
        return Cache::rememberForever('site_settings', function () {
            return SiteSetting::first() ?: new SiteSetting([
                'name' => 'Pesantren Darussaadah',
                'description' => 'Sistem Informasi Manajemen Pesantren'
            ]);
        });
    }

    public function index(): View
    {
        $settings = $this->getSettings();

        $articles = Cache::remember('home_articles', now()->addHours(1), fn () =>
            Article::with('author:id,name')
                ->select('id', 'title', 'slug', 'cover_image', 'excerpt', 'published_at', 'author_id')
                ->where('is_published', true)
                ->latest('published_at')
                ->take(3)
                ->get()
        );
            
        $facilities = Cache::remember('home_facilities', now()->addHours(12), fn () => 
            Facility::select('id', 'name', 'image_url', 'description')
                ->latest()
                ->take(4)
                ->get()
        );
        
        $galleries = Cache::remember('home_galleries', now()->addHours(12), fn () =>
            Gallery::select('id', 'title', 'image_url')
                ->latest()
                ->take(6)
                ->get()
        );
            
        $programs = Cache::rememberForever('home_programs', fn () =>
            ClassProgram::select('id', 'name', 'description')->get()
        );
        
        $testimonials = Cache::remember('home_testimonials', now()->addHours(12), fn () =>
            Testimonial::select('id', 'name', 'role', 'message')
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get()
        );

        return view('pages.home.index', compact(
            'articles', 'facilities', 'galleries', 'programs', 'testimonials', 'settings'
        ));
    }

    public function about(): View
    {
        return view('pages.about.index', ['settings' => $this->getSettings()]);
    }

    public function articles(): View
    {
        $settings = $this->getSettings();

        $articles = Article::with('author:id,name')
            ->select('id', 'title', 'slug', 'cover_image', 'excerpt', 'published_at', 'author_id')
            ->where('is_published', true)
            ->latest('published_at')
            ->simplePaginate(9);
        
        return view('pages.articles.index', compact('articles', 'settings'));
    }

    public function articleShow(string $slug): View
    {
        $settings = $this->getSettings();

        $article = Cache::remember("article_{$slug}", now()->addHours(1), function () use ($slug) {
            return Article::with('author:id,name')
                ->select('id', 'title', 'slug', 'cover_image', 'content', 'published_at', 'author_id')
                ->where('slug', $slug)
                ->where('is_published', true)
                ->first();
        });
        
        if (!$article) {
            throw new NotFoundHttpException();
        }
        
        return view('pages.articles.show', compact('article', 'settings'));
    }

    public function facilities(): View
    {
        $settings = $this->getSettings();
        
        $facilities = Cache::remember('page_facilities', now()->addHours(12), fn () =>
            Facility::select('id', 'name', 'description', 'image_url')->latest()->get()
        );
        
        return view('pages.facilities.index', compact('facilities', 'settings'));
    }

    public function galleries(): View
    {
        $settings = $this->getSettings();
        
        $galleries = Gallery::select('id', 'title', 'image_url')
            ->latest()
            ->simplePaginate(12);
        
        return view('pages.galleries.index', compact('galleries', 'settings'));
    }

    public function programs(): View
    {
        $settings = $this->getSettings();
        
        $programs = Cache::rememberForever('page_programs', fn () =>
            ClassProgram::select('id', 'name', 'description')->latest()->get()
        );
        
        return view('pages.programs.index', compact('programs', 'settings'));
    }

    public function testimonials(): View
    {
        $settings = $this->getSettings();

        // PERBAIKAN: Jangan cache paginator — pagination links menjadi stale.
        // Paginator harus di-query setiap request agar link ?page=N akurat.
        $testimonials = Testimonial::query()
            ->select('id', 'name', 'role', 'message')
            ->where('is_active', true)
            ->latest()
            ->simplePaginate(12);
        
        return view('pages.testimonials.index', compact('testimonials', 'settings'));
    }

    public function ppdbRegister(): View
    {
        $settings = $this->getSettings();
        
        $period = Cache::remember('active_registration_period', now()->addHours(1), fn () =>
            RegistrationPeriod::select(
                    'id', 'name', 'start_date', 'end_date', 'is_active', 
                    'form_schema', 'document_schema' 
                )
                ->where('is_active', true)
                ->firstOrFail()
        );
        
        return view('pages.ppdb.register', compact('period', 'settings'));
    }

    public function ppdbStore(Request $request)
    {
        $period = RegistrationPeriod::where('is_active', true)->first();

        if (!$period) {
            return back()->with('error', 'Pendaftaran sedang ditutup.');
        }

        $rules = [
            'full_name'      => 'required|string|max:255',
            'nik'            => 'required|string|max:20',
            'gender'         => 'required|in:L,P',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth'  => 'required|date',
            'phone_number'   => 'required|string|max:20',
        ];

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

        if ($period->document_schema) {
            foreach ($period->document_schema as $doc) {
                $docRule = 'file|mimes:pdf,jpg,jpeg,png|max:2048';
                if ($doc['is_required'] ?? false) {
                    $docRule .= '|required';
                }
                $rules['documents.' . $doc['document_key']] = $docRule;
            }
        }

        $validated = $request->validate($rules);

        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store("registrations/{$period->id}", 'public');
                $documentPaths[$key] = $path;
            }
        }

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

        return redirect()->route('ppdb.success', ['reg' => $registration->registration_number])
            ->with('success', 'Pendaftaran berhasil dikirim. Harap simpan Nomor Pendaftaran Anda.');
    }

    public function ppdbCheck(Request $request): View
    {
        $settings = $this->getSettings();
        $registration = null;

        if ($request->has('registration_number') && $request->filled('registration_number')) {
            // PERBAIKAN N+1: Eager-load 'period' karena view mengakses $registration->period->name
            $registration = Registration::with('period:id,name')
                ->where('registration_number', $request->registration_number)
                ->first();
        }

        return view('pages.ppdb.check-status', compact('settings', 'registration'));
    }

    public function ppdbSuccess(): View
    {
        return view('pages.ppdb.success');
    }
}