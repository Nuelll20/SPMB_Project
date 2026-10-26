<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AksesDataOrangTuaTest extends TestCase
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

    public function test_dashboard_and_history_ignore_another_parent_session(): void
    {
        [$ownerUser, $ownerParentId] = $this->createParent(
            'parent.owner@example.com',
            'Orang Tua Pemilik'
        );

        [, $otherParentId] = $this->createParent(
            'parent.other@example.com',
            'Orang Tua Lain'
        );

        $batchId = $this->createBatch(
            'Gelombang Aktif',
            3,
            true
        );

        $this->createRegistration(
            $ownerParentId,
            $batchId,
            'Anak Milik Sendiri',
            '3174010101010101'
        );

        $this->createRegistration(
            $otherParentId,
            $batchId,
            'Anak Milik Orang Lain',
            '3174010101010102'
        );

        $dashboardResponse = $this
            ->actingAs($ownerUser)
            ->withSession([
                'uid_orangtua' => $otherParentId,
            ])
            ->get(route('dashboard'));

        $dashboardResponse
            ->assertOk()
            ->assertSessionHas(
                'uid_orangtua',
                $ownerParentId
            )
            ->assertViewHas(
                'orangTua',
                fn(object $orangTua): bool =>
                    (int) $orangTua->uid === $ownerParentId
            )
            ->assertViewHas(
                'dataSiswa',
                fn(Collection $dataSiswa): bool =>
                    $dataSiswa->pluck('nama')->all() === [
                        'Anak Milik Sendiri',
                    ]
            )
            ->assertViewHas('sisaKuota', 1);

        $historyResponse = $this
            ->actingAs($ownerUser)
            ->withSession([
                'uid_orangtua' => $otherParentId,
            ])
            ->get(route('riwayat'));

        $historyResponse
            ->assertOk()
            ->assertSessionHas(
                'uid_orangtua',
                $ownerParentId
            )
            ->assertViewHas(
                'dataSiswa',
                fn(Collection $dataSiswa): bool =>
                    $dataSiswa->pluck('nama')->all() === [
                        'Anak Milik Sendiri',
                    ]
            );
    }

    public function test_dashboard_quota_ignores_other_batches(): void
    {
        [$user, $parentId] = $this->createParent(
            'quota.owner@example.com',
            'Orang Tua Kuota'
        );

        $activeBatchId = $this->createBatch(
            'Gelombang Aktif',
            2,
            true
        );

        $inactiveBatchId = $this->createBatch(
            'Gelombang Lama',
            1,
            false
        );

        $this->createRegistration(
            $parentId,
            $activeBatchId,
            'Anak Gelombang Aktif',
            '3174010101010201'
        );

        [, $otherParentId] = $this->createParent(
            'quota.other@example.com',
            'Orang Tua Batch Lama'
        );

        $this->createRegistration(
            $otherParentId,
            $inactiveBatchId,
            'Anak Gelombang Lama',
            '3174010101010202'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertViewHas('sisaKuota', 1)
            ->assertViewHas('batchAktif', true);
    }

    /**
     * @return array{0: User, 1: int}
     */
    private function createParent(
        string $email,
        string $name
    ): array {
        $user = User::factory()->create([
            'name' => $name,
            'email' => $email,
        ]);

        $parentId = DB::table('orang_tua')
            ->insertGetId([
                'user_id' => $user->id,
                'no_telp' => '081234567890',
                'nama' => $name,
                'alamat' => 'Alamat orang tua pengujian',
                'gaji' => 5000000,
                'pendidikan' => 'S1',
                'unit_sekolah' => 'SD',
                'jumlah_anak' => 1,
            ]);

        return [$user, $parentId];
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
                'alamat' => 'Alamat anak pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => 'pending',
                'nomor_registrasi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('pendaftaran')->insert([
            'no_pendaftaran' => 'TEST-' . $nik,
            'id_batch_pendaftaran' => $batchId,
            'status_pendaftaran' => 'pending',
            'tanggal_daftar' => '2026-10-26',
            'calon_siswa_id' => $studentId,
        ]);
    }
}