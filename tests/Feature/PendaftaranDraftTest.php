<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PendaftaranDraftTest extends TestCase
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

    public function test_parent_can_create_and_update_one_draft(): void
    {
        [$user, $parentId] = $this->createUserWithParentProfile(
            'draft.parent@example.com',
            'Orang Tua Draft'
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('form.daftar.draft'),
                $this->draftData('3174010101010010')
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Draft formulir anak berhasil disimpan.',
            ]);

        $draftId = (int) $response->json('uid');

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $draftId,
            'uid_orangtua' => $parentId,
            'nik' => '3174010101010010',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('form.daftar.draft'),
                $this->draftData(
                    '3174010101010011',
                    [
                        'nama_lengkap' => 'Anak Draft Diperbarui',
                        'alamat' => 'Alamat draft yang diperbarui',
                    ]
                )
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertSame(
            $draftId,
            (int) $response->json('uid')
        );

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $draftId,
            'uid_orangtua' => $parentId,
            'nik' => '3174010101010011',
            'nama' => 'Anak Draft Diperbarui',
            'alamat' => 'Alamat draft yang diperbarui',
            'status' => 'draft',
        ]);

        $this->assertDatabaseMissing('calon_siswa', [
            'nik' => '3174010101010010',
        ]);

        $this->assertSame(
            1,
            DB::table('calon_siswa')
                ->where('uid_orangtua', $parentId)
                ->where('status', 'draft')
                ->count()
        );
    }

    public function test_parent_cannot_use_nik_owned_by_another_parent(): void
    {
        [$firstUser] = $this->createUserWithParentProfile(
            'first.parent@example.com',
            'Orang Tua Pertama'
        );

        [, $secondParentId] = $this->createUserWithParentProfile(
            'second.parent@example.com',
            'Orang Tua Kedua'
        );

        $studentId = $this->createStudent(
            $secondParentId,
            '3174010101010020',
            'draft'
        );

        $response = $this
            ->actingAs($firstUser)
            ->postJson(
                route('form.daftar.draft'),
                $this->draftData('3174010101010020')
            );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'NIK ini sudah digunakan pada akun orang tua lain.',
            ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $studentId,
            'uid_orangtua' => $secondParentId,
            'nik' => '3174010101010020',
            'status' => 'draft',
        ]);
    }

    public function test_submitted_student_cannot_be_changed_back_to_draft(): void
    {
        [$user, $parentId] = $this->createUserWithParentProfile(
            'submitted.parent@example.com',
            'Orang Tua Submitted'
        );

        $studentId = $this->createStudent(
            $parentId,
            '3174010101010030',
            'pending'
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('form.daftar.draft'),
                $this->draftData('3174010101010030')
            );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'NIK ini sudah pernah disubmit. Silakan cek halaman riwayat pendaftaran.',
            ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $studentId,
            'uid_orangtua' => $parentId,
            'nik' => '3174010101010030',
            'status' => 'pending',
        ]);
    }

    /**
     * @return array{0: User, 1: int}
     */
    private function createUserWithParentProfile(
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

    private function createStudent(
        int $parentId,
        string $nik,
        string $status
    ): int {
        return DB::table('calon_siswa')
            ->insertGetId([
                'tempat_lahir' => 'Jakarta',
                'nama' => 'Anak Pemilik NIK',
                'tanggal_lahir' => '2018-05-10',
                'nik' => $nik,
                'alamat' => 'Alamat anak pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => $status,
                'nomor_registrasi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    private function draftData(
        string $nik,
        array $overrides = []
    ): array {
        return array_merge([
            'nama_lengkap' => 'Anak Draft',
            'nik' => $nik,
            'tanggal_lahir' => '2018-05-10',
            'gol_darah' => 'O',
            'agama' => 'kristen',
            'alamat' => 'Alamat anak draft',
            'tempat_lahir' => 'Jakarta',
        ], $overrides);
    }
}