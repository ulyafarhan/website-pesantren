<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'is_published',
        'author_id',
        'published_at',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya artikel yang sudah dipublikasikan dan sudah lewat jadwal tayangnya.
     * Penggunaan: Article::published()->latest('published_at')->get();
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)
              ->where('published_at', '<=', now());
    }

    /**
     * Untuk listing publik — select kolom minimum, tidak perlu 'content' yang berat.
     * Penggunaan: Article::forList()->published()->paginate(9);
     */
    public function scopeForList(Builder $query): void
    {
        $query->select([
            'id', 'title', 'slug', 'cover_image',
            'excerpt', 'published_at', 'author_id',
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Auto-generate excerpt dari content jika excerpt kosong.
     * ->shouldCache() memastikan tidak recompute berkali-kali dalam satu request.
     */
    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ?? Str::limit(strip_tags((string) ($this->attributes['content'] ?? '')), 160),
        )->shouldCache();
    }

    /**
     * Slug selalu di-slugify saat diset — mencegah karakter aneh masuk DB.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::slug($value),
        );
    }

    /**
     * cover_image mengembalikan URL lengkap atau null.
     * Fallback (placeholder) ditangani di Blade via onerror — bukan di sini.
     * ->shouldCache() mencegah asset() dipanggil berulang pada collection besar.
     */
    protected function coverImage(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ? asset('storage/' . $value)
                : null,
        )->shouldCache();
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Helper publik untuk mendapatkan URL cover dengan fallback default.
     * Dipakai di Blade: $article->getImageUrl()
     */
    public function getImageUrl(string $fallback = '/images/default-article.jpg'): string
    {
        return $this->cover_image ?? asset($fallback);
    }
}