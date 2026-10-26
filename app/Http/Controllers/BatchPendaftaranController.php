<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchPendaftaranController extends Controller
{
    private function checkAdmin(): void
    {
        if (session('role') !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function save(Request $request): JsonResponse
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'uid' => 'nullable|integer|min:1',
            'nama_batch' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => [
                'required',
                'date',
                'after_or_equal:tanggal_buka',
            ],
            'kuota' => 'required|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        $batchId = isset($validated['uid'])
            ? (int) $validated['uid']
            : null;

        $isActive = (int) $validated['is_active'];

        $result = DB::transaction(
            function () use ($validated, $batchId, $isActive): array {
                $existingBatch = null;

                if ($batchId !== null) {
                    $existingBatch = DB::table('batch_pendaftaran')
                        ->where('uid', $batchId)
                        ->lockForUpdate()
                        ->first();

                    if ($existingBatch === null) {
                        return [
                            'status' => 404,
                            'payload' => [
                                'success' => false,
                                'message' => 'Batch tidak ditemukan.',
                            ],
                        ];
                    }
                }

                if ($existingBatch !== null) {
                    $jumlahPendaftar = DB::table('pendaftaran')
                        ->where('id_batch_pendaftaran', $batchId)
                        ->count();

                    if (
                        (int) $validated['kuota']
                        < $jumlahPendaftar
                    ) {
                        return [
                            'status' => 422,
                            'payload' => [
                                'success' => false,
                                'message' => sprintf(
                                    'Kuota tidak boleh kurang dari jumlah pendaftar saat ini (%d).',
                                    $jumlahPendaftar
                                ),
                            ],
                        ];
                    }
                }

                if ($isActive === 1) {
                    $otherBatches = DB::table('batch_pendaftaran');

                    if ($batchId !== null) {
                        $otherBatches->where('uid', '!=', $batchId);
                    }

                    $otherBatches->update([
                        'is_active' => 0,
                    ]);
                }

                $data = [
                    'nama_batch' => $validated['nama_batch'],
                    'tanggal_buka' => $validated['tanggal_buka'],
                    'tanggal_tutup' => $validated['tanggal_tutup'],
                    'kuota' => $validated['kuota'],
                    'is_active' => $isActive,
                    'dibuat_oleh' => session('email') ?? 'Admin',
                ];

                if ($existingBatch !== null) {
                    DB::table('batch_pendaftaran')
                        ->where('uid', $batchId)
                        ->update($data);

                    $message = 'Batch berhasil diperbarui.';
                } else {
                    $data['cabang'] = 'Cabang Global';
                    $data['created_at'] = now();

                    $batchId = DB::table('batch_pendaftaran')
                        ->insertGetId($data);

                    $message = 'Batch baru berhasil ditambahkan.';
                }

                $totalPendaftar = DB::table('pendaftaran')
                    ->where('id_batch_pendaftaran', $batchId)
                    ->count();

                $sisaKuota = max(
                    0,
                    (int) $validated['kuota'] - $totalPendaftar
                );

                return [
                    'status' => 200,
                    'payload' => [
                        'success' => true,
                        'message' => $message,
                        'batch' => [
                            'uid' => $batchId,
                            'nama_batch' => $validated['nama_batch'],
                            'tanggal_buka' => $validated['tanggal_buka'],
                            'tanggal_tutup' => $validated['tanggal_tutup'],
                            'kuota' => (int) $validated['kuota'],
                            'is_active' => $isActive,
                            'total_pendaftar' => $totalPendaftar,
                            'sisa_kuota' => $sisaKuota,
                        ],
                    ],
                ];
            }
        );

        return response()->json(
            $result['payload'],
            $result['status']
        );
    }

    public function destroy(int $uid): JsonResponse
    {
        $this->checkAdmin();

        try {
            $result = DB::transaction(function () use ($uid): array {
                $batch = DB::table('batch_pendaftaran')
                    ->where('uid', $uid)
                    ->lockForUpdate()
                    ->first();

                if ($batch === null) {
                    return [
                        'status' => 404,
                        'payload' => [
                            'success' => false,
                            'message' => 'Batch tidak ditemukan.',
                        ],
                    ];
                }

                $jumlahPendaftar = DB::table('pendaftaran')
                    ->where('id_batch_pendaftaran', $uid)
                    ->count();

                if ($jumlahPendaftar > 0) {
                    return [
                        'status' => 422,
                        'payload' => [
                            'success' => false,
                            'message' => 'Batch tidak bisa dihapus karena sudah memiliki pendaftar.',
                        ],
                    ];
                }

                DB::table('batch_pendaftaran')
                    ->where('uid', $uid)
                    ->delete();

                return [
                    'status' => 200,
                    'payload' => [
                        'success' => true,
                        'message' => 'Batch berhasil dihapus.',
                    ],
                ];
            });
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }

            return response()->json([
                'success' => false,
                'message' => 'Batch tidak bisa dihapus karena masih digunakan.',
            ], 422);
        }

        return response()->json(
            $result['payload'],
            $result['status']
        );
    }
}