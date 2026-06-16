<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pendaftaran') && !Schema::hasColumn('pendaftaran', 'tanggal_verifikasi')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->timestamp('tanggal_verifikasi')->nullable()->after('tanggal_daftar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pendaftaran') && Schema::hasColumn('pendaftaran', 'tanggal_verifikasi')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->dropColumn('tanggal_verifikasi');
            });
        }
    }
};
