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
        Schema::table('orang_tua', function (Blueprint $table) {
            //
            $table->string('pendidikan')->nullable()->after('gaji');
            $table->string('unit_sekolah')->nullable()->after('pendidikan');
            $table->integer('jumlah_anak')->nullable()->after('unit_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            //
            $table->dropColumn(['pendidikan', 'unit_sekolah', 'jumlah_anak']);
        });
    }
};
