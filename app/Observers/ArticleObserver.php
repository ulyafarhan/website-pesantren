<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     * Jika slug berubah, kita hapus cache slug LAMA juga
     * agar halaman lama tidak muncul stale dari cache.
     */
    public function saved(Article $article): void
    {
        // Jika slug berubah saat UPDATE, hapus cache slug yang lama
        if ($article->wasChanged('slug')) {
            $oldSlug = $article->getOriginal('slug');
            Cache::forget("api_article_{$oldSlug}");
            Cache::forget("article_{$oldSlug}");
        }

        // Hapus cache slug saat ini
        Cache::forget("api_article_{$article->slug}");
        Cache::forget("article_{$article->slug}");

        // Hapus cache listing publik
        Cache::forget('api_articles');
        Cache::forget('home_articles');

        // Hapus cache dashboard admin
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah DELETE.
     * Pastikan artikel yang dihapus tidak muncul lagi di cache manapun.
     */
    public function deleted(Article $article): void
    {
        Cache::forget("api_article_{$article->slug}");
        Cache::forget("article_{$article->slug}");
        Cache::forget('api_articles');
        Cache::forget('home_articles');
        Cache::forget('dashboard_stats');
    }
}