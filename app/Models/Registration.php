<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'registration_period_id',
        'registration_number',
        'full_name',
        'nik',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'phone_number',
        'data',
        'documents',
        'status',
        'test_score',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'data'         => 'array',
        'documents'    => 'array',
        'date_of_birth'=> 'date',
        'verified_at'  => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'test_score'   => 'float',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Filter berdasarkan status seleksi.
     * Penggunaan: Registration::ofStatus('PENDING')->get();
     */
    public function scopeOfStatus(Builder $query, string $status): void
    {
        $query->where('status', strtoupper($status));
    }

    /**
     * Hanya pendaftar yang masih menunggu verifikasi.
     * Penggunaan: Registration::pending()->count();
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'PENDING');
    }

    /**
     * Hanya pendaftar yang sudah diterima.
     */
    public function scopeAccepted(Builder $query): void
    {
        $query->where('status', 'ACCEPTED');
    }

    /**
     * Filter berdasarkan gelombang pendaftaran.
     * Penggunaan: Registration::forPeriod($periodId)->get();
     */
    public function scopeForPeriod(Builder $query, string $periodId): void
    {
        $query->where('registration_period_id', $periodId);
    }

    /**
     * Kolom minimum untuk tabel listing admin (tidak tarik JSON 'data' & 'documents' yang besar).
     * Penggunaan: Registration::forTable()->with('period:id,name')->paginate(25);
     */
    public function scopeForTable(Builder $query): void
    {
        $query->select([
            'id', 'registration_number', 'full_name',
            'gender', 'status', 'test_score',
            'registration_period_id', 'created_at',
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function period(): BelongsTo
    {
        return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Cek apakah status pendaftaran sudah final (tidak bisa diubah lagi).
     */
    public function isFinal(): bool
    {
        return in_array($this->status, ['ACCEPTED', 'REJECTED', 'REGISTERED', 'WITHDRAWN'], true);
    }

    /**
     * Label status dalam Bahasa Indonesia untuk tampilan publik.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'PENDING'    => 'Menunggu Verifikasi',
            'VERIFIED'   => 'Berkas Terverifikasi',
            'TESTING'    => 'Tahap Seleksi',
            'ACCEPTED'   => 'Diterima',
            'REJECTED'   => 'Tidak Lulus',
            'WITHDRAWN'  => 'Mengundurkan Diri',
            'REGISTERED' => 'Daftar Ulang Selesai',
            default      => $this->status,
        };
    }
}