<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\ClassProgram;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Mengambil pengaturan situs dengan Cache TTL 24 jam.
     * Menggunakan 'firstOr' untuk menangani kasus jika database kosong agar tidak error.
     */
    private function getSettings(): SiteSetting
    {
        return Cache::remember('site_settings', now()->addDay(), fn () => 
            SiteSetting::first() ?? new SiteSetting([
                'name' => 'Website Pesantren',
                'description' => 'Sistem Informasi Manajemen Pesantren'
            ])
        );
    }

    /**
     * Landing Page Utama
     */
    public function index(): View
    {
        $settings = $this->getSettings();

        // Menggunakan scope 'published' (asumsi dibuat di model) untuk clean code
        // Eager loading 'user' (atau 'author') untuk mencegah N+1
        $articles = Article::with('author')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();
            
        $facilities = Cache::remember('home_facilities', now()->addHours(6), fn () => 
            Facility::latest()->take(4)->get()
        );
        
        $galleries = Gallery::latest()->take(6)->get();
            
        $programs = ClassProgram::all();
        
        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home.index', compact(
            'articles', 
            'facilities', 
            'galleries', 
            'programs', 
            'testimonials', 
            'settings'
        ));
    }

    /**
     * Daftar Artikel Berita
     */
    public function articles(): View
    {
        $settings = $this->getSettings();

        // PENTING: Eager loading 'author' wajib untuk looping di Blade
        $articles = Article::with('author')
            ->published()
            ->latest('published_at')
            ->paginate(9);
        
        return view('pages.articles.index', compact('articles', 'settings'));
    }

    /**
     * Detail Artikel tunggal
     */
    public function articleShow(string $slug): View
    {
        $settings = $this->getSettings();

        $article = Article::with('author')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        return view('pages.articles.show', compact('article', 'settings'));
    }

    /**
     * Daftar Fasilitas
     */
    public function facilities(): View
    {
        $settings = $this->getSettings();
        $facilities = Facility::latest()->get();
        
        return view('pages.facilities.index', compact('facilities', 'settings'));
    }

    /**
     * Galeri Foto dengan Pagination
     */
    public function galleries(): View
    {
        $settings = $this->getSettings();
        
        // Pagination krusial untuk gallery agar tidak terjadi memory leak saat data ribuan
        $galleries = Gallery::latest()->paginate(12);
        
        return view('pages.galleries.index', compact('galleries', 'settings'));
    }

    /**
     * Program Belajar / Kelas
     */
    public function programs(): View
    {
        $settings = $this->getSettings();
        $programs = ClassProgram::latest()->get();
        
        return view('pages.programs.index', compact('programs', 'settings'));
    }

    /**
     * Testimonial Lengkap
     */
    public function testimonials(): View
    {
        $settings = $this->getSettings();
        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->paginate(12);
        
        return view('pages.testimonials.index', compact('testimonials', 'settings'));
    }
}