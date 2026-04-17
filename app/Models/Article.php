<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Scope: Menampilkan artikel yang sudah dipublikasikan saja.
     * Digunakan di Controller: Article::published()->get();
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)
              ->where('published_at', '<=', now());
    }

    /**
     * Relationship: Penulis Artikel.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Perbaikan SEO: Otomatis memotong excerpt jika kosong.
     * Menggunakan Property Hooks / Accessor standar.
     */
    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? Str::limit(strip_tags((string) $this->content), 160),
        );
    }

    /**
     * Perbaikan Keamanan: Memastikan slug selalu valid URL.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::slug($value),
        );
    }

    /**
     * Helper: Mendapatkan URL gambar cover dengan fallback.
     */
    public function getImageUrl(): string
    {
        if (! $this->cover_image) {
            return asset('images/default-article.jpg');
        }

        return asset('storage/' . $this->cover_image);
    }

    protected function coverImage(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                // Jika data di database kosong
                if (! $value) {
                    return 'https://placehold.co/600x400?text=No+Image';
                }

                // Jika ada data di DB, cek apakah filenya benar-benar ada di storage
                if (! \Illuminate\Support\Facades\Storage::disk('public')->exists($value)) {
                    return 'https://placehold.co/600x400?text=Image+Not+Found';
                }

                return asset('storage/' . $value);
            }
        );
    }
}