<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index(['registration_period_id', 'status']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->index(['is_active', 'created_at']);
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['registration_period_id', 'status']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'created_at']);
        });
    }
};
