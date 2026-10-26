<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KepsekMetricsTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assertSame(
            'db_spmb_testing',
            DB::connection()->getDatabaseName(),
            'Test harus dijalankan menggunakan db_spmb_testing.'
        );
    }

    public function test_quota_metrics_only_count_active_batch(): void
    {
        $parentId = $this->createParent();

        $activeBatchId = $this->createBatch(
            'Gelombang Aktif',
            4,
            true
        );

        $inactiveBatchId = $this->createBatch(
            'Gelombang Lama',
            2,
            false
        );

        $this->createRegistration(
            $parentId,
            $activeBatchId,
            'Siswa Aktif Pertama',
            '3174010101011001'
        );

        $this->createRegistration(
            $parentId,
            $activeBatchId,
            'Siswa Aktif Kedua',
            '3174010101011002'
        );

        $this->createRegistration(
            $parentId,
            $inactiveBatchId,
            'Siswa Gelombang Lama',
            '3174010101011003'
        );

        $response = $this
            ->withSession([
                'role' => 'kepsek',
                'staff_login' => true,
                'email' => 'kepsek.testing@example.com',
            ])
            ->get(route('kepsek.dashboard'));

        $response
            ->assertOk()
            ->assertViewHas(
                'metrics',
                function (array $metrics) use (
                    $activeBatchId
                ): bool {
                    return $metrics['total'] === 3
                        && $metrics['active_batch_total'] === 2
                        && $metrics['quota'] === 4
                        && $metrics['remaining_quota'] === 2
                        && (float) $metrics['percentage'] === 50.0
                        && (int) $metrics['active_batch']->uid
                            === $activeBatchId;
                }
            );
    }

    public function test_inactive_batch_is_not_treated_as_active(): void
    {
        $parentId = $this->createParent();

        $inactiveBatchId = $this->createBatch(
            'Gelombang Tidak Aktif',
            5,
            false
        );

        $this->createRegistration(
            $parentId,
            $inactiveBatchId,
            'Siswa Batch Tidak Aktif',
            '3174010101012001'
        );

        $response = $this
            ->withSession([
                'role' => 'kepsek',
                'staff_login' => true,
                'email' => 'kepsek.testing@example.com',
            ])
            ->get(route('kepsek.dashboard'));

        $response
            ->assertOk()
            ->assertViewHas(
                'metrics',
                function (array $metrics): bool {
                    return $metrics['total'] === 1
                        && $metrics['active_batch_total'] === 0
                        && $metrics['quota'] === 0
                        && $metrics['remaining_quota'] === 0
                        && (float) $metrics['percentage'] === 0.0
                        && $metrics['active_batch'] === null;
                }
            );
    }

    private function createParent(): int
    {
        return DB::table('orang_tua')
            ->insertGetId([
                'user_id' => null,
                'no_telp' => '081234567890',
                'nama' => 'Orang Tua Pengujian Metrik',
                'alamat' => 'Alamat orang tua pengujian',
                'gaji' => 5000000,
                'pendidikan' => 'S1',
                'unit_sekolah' => 'SD',
                'jumlah_anak' => 3,
            ]);
    }

    private function createBatch(
        string $name,
        int $quota,
        bool $active
    ): int {
        return DB::table('batch_pendaftaran')
            ->insertGetId([
                'cabang' => 'Cabang Pengujian',
                'nama_batch' => $name,
                'tanggal_buka' => '2026-10-01',
                'tanggal_tutup' => '2026-10-31',
                'kuota' => $quota,
                'is_active' => $active ? 1 : 0,
                'created_at' => '2026-10-01',
                'dibuat_oleh' => 'admin.testing@example.com',
            ]);
    }

    private function createRegistration(
        int $parentId,
        int $batchId,
        string $studentName,
        string $nik
    ): void {
        $studentId = DB::table('calon_siswa')
            ->insertGetId([
                'tempat_lahir' => 'Jakarta',
                'nama' => $studentName,
                'tanggal_lahir' => '2018-05-10',
                'nik' => $nik,
                'alamat' => 'Alamat siswa pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => 'pending',
                'nomor_registrasi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('pendaftaran')->insert([
            'no_pendaftaran' => 'METRIK-' . $nik,
            'id_batch_pendaftaran' => $batchId,
            'status_pendaftaran' => 'pending',
            'tanggal_daftar' => '2026-10-26',
            'calon_siswa_id' => $studentId,
        ]);
    }
}