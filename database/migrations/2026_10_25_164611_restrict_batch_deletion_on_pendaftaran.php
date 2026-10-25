<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign('pendaftaran_ibfk_1');

            $table->foreign(
                'id_batch_pendaftaran',
                'pendaftaran_batch_foreign'
            )
                ->references('uid')
                ->on('batch_pendaftaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign('pendaftaran_batch_foreign');

            $table->foreign(
                'id_batch_pendaftaran',
                'pendaftaran_ibfk_1'
            )
                ->references('uid')
                ->on('batch_pendaftaran')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }
};