<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tagihan')) {
            return;
        }

        Schema::table('tagihan', function (Blueprint $table) {
            if (! Schema::hasColumn('tagihan', 'subtotal_tagihan')) {
                $table->decimal('subtotal_tagihan', 15, 2)->default(0)->after('nomor_tagihan');
            }

            if (! Schema::hasColumn('tagihan', 'diskon_tagihan')) {
                $table->decimal('diskon_tagihan', 15, 2)->default(0)->after('subtotal_tagihan');
            }

            if (! Schema::hasColumn('tagihan', 'catatan_kepsek')) {
                $table->string('catatan_kepsek')->nullable()->after('tanggal_tagihan');
            }

            if (! Schema::hasColumn('tagihan', 'dibuat_oleh')) {
                $table->string('dibuat_oleh')->nullable()->after('catatan_kepsek');
            }

            if (! Schema::hasColumn('tagihan', 'disetujui_oleh')) {
                $table->string('disetujui_oleh')->nullable()->after('dibuat_oleh');
            }

            if (! Schema::hasColumn('tagihan', 'created_at')) {
                $table->dateTime('created_at')->nullable()->after('disetujui_oleh');
            }

            if (! Schema::hasColumn('tagihan', 'updated_at')) {
                $table->dateTime('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('tagihan')) {
            return;
        }

        Schema::table('tagihan', function (Blueprint $table) {
            foreach ([
                'catatan_kepsek',
                'disetujui_oleh',
            ] as $column) {
                if (Schema::hasColumn('tagihan', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
