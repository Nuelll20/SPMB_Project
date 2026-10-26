<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AksesBerkasTest extends TestCase
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

        Storage::fake('local');
    }

    public function test_guest_cannot_access_parent_document(): void
    {
        $response = $this->get(
            route('berkas.show', ['uid' => 999])
        );

        $response->assertRedirect(route('login'));
    }

    public function test_parent_can_access_own_document(): void
    {
        [$user, $parentId] = $this->createUserWithParentProfile(
            'owner@example.com',
            'Orang Tua Pemilik'
        );

        $documentId = $this->createDocumentForParent(
            $parentId,
            'berkas/testing/pemilik/kartu-keluarga.pdf',
            true
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('berkas.show', [
                    'uid' => $documentId,
                    'filename' => 'kartu-keluarga.pdf',
                ])
            );

        $response->assertOk();
        $response->assertHeader(
            'X-Content-Type-Options',
            'nosniff'
        );

        $cacheControl = (string) $response->headers->get(
            'Cache-Control'
        );

        $this->assertStringContainsString(
            'private',
            $cacheControl
        );
        $this->assertStringContainsString(
            'no-store',
            $cacheControl
        );

        $contentDisposition = (string) $response->headers->get(
            'Content-Disposition'
        );

        $this->assertStringContainsString(
            'inline',
            $contentDisposition
        );
        $this->assertStringContainsString(
            'kartu-keluarga.pdf',
            $contentDisposition
        );

        $this->assertSame(
            'isi berkas pengujian',
            $response->streamedContent()
        );
    }

    public function test_parent_cannot_access_another_parent_document(): void
    {
        [, $ownerParentId] = $this->createUserWithParentProfile(
            'document.owner@example.com',
            'Pemilik Berkas'
        );

        [$otherUser] = $this->createUserWithParentProfile(
            'other.parent@example.com',
            'Orang Tua Lain'
        );

        $documentId = $this->createDocumentForParent(
            $ownerParentId,
            'berkas/testing/pemilik-lain/akte-kelahiran.pdf',
            true
        );

        $response = $this
            ->actingAs($otherUser)
            ->get(
                route('berkas.show', [
                    'uid' => $documentId,
                    'filename' => 'akte-kelahiran.pdf',
                ])
            );

        $response->assertNotFound();
    }

    public function test_admin_can_access_parent_document(): void
    {
        [, $parentId] = $this->createUserWithParentProfile(
            'admin.document.owner@example.com',
            'Pemilik Berkas Admin'
        );

        $documentId = $this->createDocumentForParent(
            $parentId,
            'berkas/testing/admin/ktp-orang-tua.pdf',
            true,
            'E-KTP Orang Tua'
        );

        $response = $this
            ->withSession([
                'role' => 'admin',
                'staff_login' => true,
            ])
            ->get(
                route('admin.berkas.show', [
                    'uid' => $documentId,
                    'filename' => 'ktp-orang-tua.pdf',
                ])
            );

        $response->assertOk();
        $response->assertHeader(
            'X-Content-Type-Options',
            'nosniff'
        );

        $this->assertSame(
            'isi berkas pengujian',
            $response->streamedContent()
        );
    }

    public function test_non_admin_cannot_access_admin_document_route(): void
    {
        $response = $this->get(
            route('admin.berkas.show', ['uid' => 999])
        );

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_dangerous_document_path_is_rejected(): void
    {
        [, $parentId] = $this->createUserWithParentProfile(
            'dangerous.path@example.com',
            'Pemilik Path Berbahaya'
        );

        $documentId = $this->createDocumentForParent(
            $parentId,
            'berkas/../rahasia.txt',
            false
        );

        $response = $this
            ->withSession([
                'role' => 'admin',
                'staff_login' => true,
            ])
            ->get(
                route('admin.berkas.show', [
                    'uid' => $documentId,
                    'filename' => 'rahasia.txt',
                ])
            );

        $response->assertNotFound();
    }

    public function test_missing_physical_document_is_not_served(): void
    {
        [$user, $parentId] = $this->createUserWithParentProfile(
            'missing.document@example.com',
            'Pemilik Berkas Hilang'
        );

        $documentId = $this->createDocumentForParent(
            $parentId,
            'berkas/testing/hilang/berkas-hilang.pdf',
            false
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('berkas.show', [
                    'uid' => $documentId,
                    'filename' => 'berkas-hilang.pdf',
                ])
            );

        $response->assertNotFound();
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

    private function createDocumentForParent(
        int $parentId,
        string $path,
        bool $createPhysicalFile,
        string $documentType = 'Kartu Keluarga'
    ): int {
        $batchId = DB::table('batch_pendaftaran')
            ->insertGetId([
                'cabang' => 'Cabang Pengujian',
                'nama_batch' => 'Batch Berkas',
                'tanggal_buka' => now()->subDay()->toDateString(),
                'tanggal_tutup' => now()->addDay()->toDateString(),
                'kuota' => 10,
                'is_active' => 1,
                'created_at' => now()->toDateString(),
                'dibuat_oleh' => 'PHPUnit',
            ]);

        $studentId = DB::table('calon_siswa')
            ->insertGetId([
                'tempat_lahir' => 'Jakarta',
                'nama' => 'Anak Pemilik Berkas',
                'tanggal_lahir' => '2018-05-10',
                'nik' => str_pad(
                    (string) $parentId,
                    16,
                    '0',
                    STR_PAD_LEFT
                ),
                'alamat' => 'Alamat anak pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => 'pending',
                'nomor_registrasi' => null,
            ]);

        $registrationNumber = 'REG-TEST-'
            . str_pad(
                (string) $studentId,
                5,
                '0',
                STR_PAD_LEFT
            );

        DB::table('calon_siswa')
            ->where('uid', $studentId)
            ->update([
                'nomor_registrasi' => $registrationNumber,
            ]);

        $registrationId = DB::table('pendaftaran')
            ->insertGetId([
                'no_pendaftaran' => $registrationNumber,
                'id_batch_pendaftaran' => $batchId,
                'status_pendaftaran' => 'pending',
                'tanggal_daftar' => now()->toDateString(),
                'calon_siswa_id' => $studentId,
            ]);

        $documentId = DB::table('berkas')
            ->insertGetId([
                'id_pendaftar' => $registrationId,
                'jenis_berkas' => $documentType,
                'file_url' => $path,
                'is_valid' => 0,
            ]);

        if ($createPhysicalFile) {
            Storage::disk('local')->put(
                $path,
                'isi berkas pengujian'
            );
        }

        return $documentId;
    }
}