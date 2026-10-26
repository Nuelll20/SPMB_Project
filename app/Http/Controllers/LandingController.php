<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LandingController extends Controller
{
    public function __invoke()
    {
        $landingInfo = [
            'batch' => null,
            'batch_list' => collect(),
            'total_pendaftar' => 0,
            'approved' => 0,
            'rejected' => 0,
            'proses' => 0,
            'sisa_kuota' => 0,
            'is_open' => false,
        ];

        try {
            if (Schema::hasTable('pendaftaran')) {
                $landingInfo['total_pendaftar'] =
                    DB::table('pendaftaran')->count();

                $landingInfo['approved'] =
                    DB::table('pendaftaran')
                        ->where('status_pendaftaran', 'approved')
                        ->count();

                $landingInfo['rejected'] =
                    DB::table('pendaftaran')
                        ->where('status_pendaftaran', 'rejected')
                        ->count();

                $landingInfo['proses'] =
                    DB::table('pendaftaran')
                        ->where(function ($query) {
                            $query->whereNull('status_pendaftaran')
                                ->orWhereIn(
                                    'status_pendaftaran',
                                    ['pending', 'proses', 'draft']
                                );
                        })
                        ->count();
            }

            if (Schema::hasTable('batch_pendaftaran')) {
                $batch = DB::table('batch_pendaftaran')
                    ->where('is_active', 1)
                    ->orderByDesc('tanggal_buka')
                    ->orderByDesc('uid')
                    ->first();

                if (! $batch) {
                    $batch = DB::table('batch_pendaftaran')
                        ->orderByDesc('tanggal_buka')
                        ->orderByDesc('uid')
                        ->first();
                }

                $landingInfo['batch'] = $batch;

                if ($batch) {
                    $jumlahBatch = Schema::hasTable('pendaftaran')
                        ? DB::table('pendaftaran')
                            ->where(
                                'id_batch_pendaftaran',
                                $batch->uid
                            )
                            ->count()
                        : 0;

                    $landingInfo['sisa_kuota'] = max(
                        0,
                        (int) ($batch->kuota ?? 0) - $jumlahBatch
                    );

                    $landingInfo['is_open'] =
                        (int) ($batch->is_active ?? 0) === 1
                        && $landingInfo['sisa_kuota'] > 0;
                }

                $landingInfo['batch_list'] =
                    DB::table('batch_pendaftaran')
                        ->orderByDesc('tanggal_buka')
                        ->orderByDesc('uid')
                        ->limit(3)
                        ->get();
            }
        } catch (\Throwable $e) {
            // Landing page tetap bisa dibuka ketika database belum siap.
        }

        return view('landing', compact('landingInfo'));
    }
}