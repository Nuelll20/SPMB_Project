<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel.
     */
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' otomatis (Primary Key & Auto Increment)
            
            // Contoh macam-macam tipe data kolom di Laravel:
            $table->string('nisn', 10)->unique();     // VARCHAR(10) dan tidak boleh kembar
            $table->string('nama_lengkap');            // VARCHAR(255)
            $table->text('alamat_rumah');              // TEXT (untuk teks yang panjang)
            $table->integer('jumlah_saudara');         // INT (untuk angka bulat)
            $table->bigInteger('biaya_pendaftaran');   // BIGINT (untuk angka nominal besar)
            $table->date('tanggal_lahir');             // DATE (untuk tanggal)
            $table->enum('jenis_kelamin', ['L', 'P']); // ENUM (pilihan terbatas)
            
            // Jika kolom boleh dikosongkan (boleh NULL di DB), tambahkan ->nullable()
            $table->string('catatan_medis')->nullable(); 
            
            $table->timestamps(); // Otomatis membuat kolom 'created_at' & 'updated_at'
        });
    }

    /**
     * Batalkan migration (menghapus tabel jika di-rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};