<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\ClassProgram;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();
            
        $facilities = Facility::all();
        
        $galleries = Gallery::latest()
            ->take(6)
            ->get();
            
        $programs = ClassProgram::all();
        
        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();
        
        // Mengambil baris pertama data pengaturan website
        $settings = SiteSetting::first();

        return view('pages.home.index', compact('articles', 'facilities', 'galleries', 'programs', 'testimonials', 'settings'));
    }

    public function articles()
    {
        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);
            
        $settings = SiteSetting::first();
        
        return view('pages.articles.index', compact('articles', 'settings'));
    }

    public function articleShow($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
            
        $settings = SiteSetting::first();
        
        return view('pages.articles.show', compact('article', 'settings'));
    }

    // --- TAMBAHAN METHOD BARU SESUAI ROUTE WEB.PHP ---

    public function facilities()
    {
        $facilities = Facility::latest()->get();
        $settings = SiteSetting::first();
        
        return view('pages.facilities.index', compact('facilities', 'settings'));
    }

    public function galleries()
    {
        // Menggunakan pagination agar jika foto banyak, web tidak berat
        $galleries = Gallery::latest()->paginate(12);
        $settings = SiteSetting::first();
        
        return view('pages.galleries.index', compact('galleries', 'settings'));
    }

    public function programs()
    {
        $programs = ClassProgram::latest()->get();
        $settings = SiteSetting::first();
        
        return view('pages.programs.index', compact('programs', 'settings'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->latest()->paginate(12);
        $settings = SiteSetting::first();
        
        return view('pages.testimonials.index', compact('testimonials', 'settings'));
    }
}