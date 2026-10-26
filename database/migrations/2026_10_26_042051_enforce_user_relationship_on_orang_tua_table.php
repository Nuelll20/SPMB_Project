<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            $table->unique(
                'user_id',
                'orang_tua_user_id_unique'
            );

            $table->foreign(
                'user_id',
                'orang_tua_user_id_foreign'
            )
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            $table->dropForeign(
                'orang_tua_user_id_foreign'
            );

            $table->dropUnique(
                'orang_tua_user_id_unique'
            );
        });
    }
};