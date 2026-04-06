<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk mengatur gelombang pendaftaran
        Schema::create('registration_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Contoh: Gelombang 1 - Tahun Ajaran 2026/2027
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('quota')->default(0); // Kuota santri
            $table->decimal('registration_fee', 12, 2)->default(0); // Biaya pendaftaran
            $table->boolean('is_active')->default(false);
            
            // Schema dinamis untuk isian tambahan tiap tahun
            $table->json('form_schema')->nullable(); 
            $table->json('document_schema')->nullable();
            $table->timestamps();
        });

        // Tabel inti data pendaftar (Calon Santri)
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('registration_period_id')
                ->constrained('registration_periods')
                ->cascadeOnDelete();
            
            // Identitas Inti (Wajib ada di kolom tersendiri untuk filter/search)
            $table->string('registration_number')->unique(); // REG-2026001
            $table->string('full_name');
            $table->string('nik', 16)->nullable()->index();
            $table->enum('gender', ['L', 'P'])->index();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable(); // No WA Orang Tua
            
            // Data Fleksibel (Isian dinamis tahunan masuk sini)
            $table->json('data')->nullable(); 
            $table->json('documents')->nullable(); // Path berkas: KK, Akta, dll
            
            // Alur Administrasi Pesantren (Pipeline)
            $table->enum('status', [
                'PENDING',      // Baru mendaftar
                'VERIFIED',     // Berkas sudah dicek admin & valid
                'TESTING',      // Sedang proses ujian/tes seleksi
                'ACCEPTED',     // Lulus seleksi
                'REJECTED',     // Tidak lulus
                'WITHDRAWN',    // Mengundurkan diri
                'REGISTERED'    // Sudah daftar ulang & resmi jadi santri
            ])->default('PENDING')->index();

            // Data Akademik/Seleksi (Internal Admin)
            $table->decimal('test_score', 5, 2)->nullable(); // Nilai rata-rata tes
            $table->text('admin_notes')->nullable(); // Catatan pewawancara/admin
            
            // Audit Trail
            $table->timestamp('verified_at')->nullable();
            $table->foreignUuid('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('registration_periods');
    }
};