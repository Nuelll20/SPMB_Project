<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('orang_tua')) {
            return;
        }

        if (!Schema::hasColumn('orang_tua', 'pendidikan')) {
            Schema::table('orang_tua', function (Blueprint $table) {
                $table->string('pendidikan')
                    ->nullable()
                    ->after('gaji');
            });
        }

        if (!Schema::hasColumn('orang_tua', 'unit_sekolah')) {
            Schema::table('orang_tua', function (Blueprint $table) {
                $table->string('unit_sekolah')
                    ->nullable()
                    ->after('pendidikan');
            });
        }

        if (!Schema::hasColumn('orang_tua', 'jumlah_anak')) {
            Schema::table('orang_tua', function (Blueprint $table) {
                $table->integer('jumlah_anak')
                    ->nullable()
                    ->after('unit_sekolah');
            });
        }
    }

    public function down(): void
    {
        // Kolom-kolom ini dapat berasal dari database lama yang diimpor.
        // Tidak dihapus otomatis untuk mencegah kehilangan data saat rollback.
    }
};