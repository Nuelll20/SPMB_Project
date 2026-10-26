<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('pendaftar')) {
            return;
        }

        if (DB::table('pendaftar')->exists()) {
            throw new RuntimeException(
                'Tabel pendaftar masih berisi data dan tidak boleh dihapus.'
            );
        }

        Schema::drop('pendaftar');
    }

    public function down(): void
    {
        if (Schema::hasTable('pendaftar')) {
            return;
        }

        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();
            $table->string('nama_lengkap');
            $table->text('alamat_rumah');
            $table->integer('jumlah_saudara');
            $table->bigInteger('biaya_pendaftaran');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('catatan_medis')->nullable();
            $table->timestamps();
        });
    }
};