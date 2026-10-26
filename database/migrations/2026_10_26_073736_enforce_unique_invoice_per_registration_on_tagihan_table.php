<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $duplicate = DB::table('tagihan')
            ->select('uid_pendaftaran')
            ->groupBy('uid_pendaftaran')
            ->havingRaw('COUNT(*) > 1')
            ->first();

        if ($duplicate !== null) {
            throw new RuntimeException(
                'Masih terdapat lebih dari satu tagihan untuk pendaftaran yang sama.'
            );
        }

        Schema::table('tagihan', function (Blueprint $table) {
            $table->unique(
                'uid_pendaftaran',
                'tagihan_uid_pendaftaran_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropUnique(
                'tagihan_uid_pendaftaran_unique'
            );
        });
    }
};