<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminVerifikasiTest extends TestCase
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

    public function test_non_admin_cannot_approve_registration(): void
    {
        $registration = $this->createPendingRegistration();

        $response = $this->postJson(
            route(
                'admin.pendaftaran.approve',
                $registration['registration_id']
            )
        );

        $response
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Akses admin ditolak. Silakan login sebagai admin terlebih dahulu.',
            ]);

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'pending',
        ]);
    }

    public function test_admin_can_approve_registration(): void
    {
        $registration = $this->createPendingRegistration();

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.approve',
                    $registration['registration_id']
                )
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Pendaftar berhasil diloloskan.',
                'diverifikasi_oleh' => 'admin.testing@example.com',
            ]);

        $response->assertJsonPath(
            'invoice_url',
            route(
                'admin.pendaftaran.invoice',
                $registration['registration_id']
            )
        );

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'approved',
            'alasan_penolakan' => null,
            'diverifikasi_oleh' => 'admin.testing@example.com',
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $registration['student_id'],
            'status' => 'approved',
        ]);

        $this->assertSame(
            3,
            DB::table('berkas')
                ->where(
                    'id_pendaftar',
                    $registration['registration_id']
                )
                ->where('is_valid', 1)
                ->count()
        );

        $verifiedAt = DB::table('pendaftaran')
            ->where('uid', $registration['registration_id'])
            ->value('tanggal_verifikasi');

        $this->assertNotNull($verifiedAt);
    }

    public function test_rejection_requires_a_reason(): void
    {
        $registration = $this->createPendingRegistration();

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.reject',
                    $registration['registration_id']
                ),
                [
                    'jenis_penolakan' => 'berkas',
                    'invalid_berkas' => ['Akte Kelahiran'],
                ]
            );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('alasan');

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'pending',
            'alasan_penolakan' => null,
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $registration['student_id'],
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_reject_registration_and_mark_invalid_documents(): void
    {
        $registration = $this->createPendingRegistration();

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.reject',
                    $registration['registration_id']
                ),
                [
                    'alasan' => 'Akte kelahiran tidak terbaca.',
                    'jenis_penolakan' => 'berkas',
                    'invalid_berkas' => ['Akte Kelahiran'],
                ]
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Pendaftar berhasil ditolak.',
                'diverifikasi_oleh' => 'admin.testing@example.com',
            ]);

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'rejected',
            'jenis_penolakan' => 'berkas',
            'alasan_penolakan' => 'Akte kelahiran tidak terbaca.',
            'diverifikasi_oleh' => 'admin.testing@example.com',
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $registration['student_id'],
            'status' => 'rejected',
        ]);

        $this->assertDatabaseHas('berkas', [
            'id_pendaftar' => $registration['registration_id'],
            'jenis_berkas' => 'Akte Kelahiran',
            'is_valid' => 0,
        ]);

        $this->assertDatabaseHas('berkas', [
            'id_pendaftar' => $registration['registration_id'],
            'jenis_berkas' => 'Kartu Keluarga',
            'is_valid' => 1,
        ]);

        $this->assertDatabaseHas('berkas', [
            'id_pendaftar' => $registration['registration_id'],
            'jenis_berkas' => 'Pas Foto',
            'is_valid' => 1,
        ]);

        $verifiedAt = DB::table('pendaftaran')
            ->where('uid', $registration['registration_id'])
            ->value('tanggal_verifikasi');

        $this->assertNotNull($verifiedAt);
    }

    public function test_admin_can_validate_single_document(): void
    {
        $registration = $this->createPendingRegistration();
        $documentId = $registration['document_ids'][0];

        $response = $this
            ->withSession($this->adminSession())
            ->from(route('admin.dashboard'))
            ->post(
                route('admin.berkas.validasi', [
                    'id' => $documentId,
                    'status' => 1,
                ])
            );

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('berkas', [
            'uid' => $documentId,
            'is_valid' => 1,
        ]);
    }

    /**
     * @return array{
     *     registration_id: int,
     *     student_id: int,
     *     document_ids: array<int, int>
     * }
     */

    public function test_unknown_document_cannot_be_validated(): void
    {
        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route('admin.berkas.validasi', [
                    'id' => 999999,
                    'status' => 1,
                ])
            );

        $response->assertNotFound();
    }

    public function test_existing_document_with_same_status_is_still_found(): void
    {
        $registration = $this->createPendingRegistration();
        $documentId = $registration['document_ids'][0];

        $this->assertDatabaseHas('berkas', [
            'uid' => $documentId,
            'is_valid' => 0,
        ]);

        $response = $this
            ->withSession($this->adminSession())
            ->from(route('admin.dashboard'))
            ->post(
                route('admin.berkas.validasi', [
                    'id' => $documentId,
                    'status' => 0,
                ])
            );

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas(
            'success',
            'Status berkas berhasil diupdate!'
        );

        $this->assertDatabaseHas('berkas', [
            'uid' => $documentId,
            'is_valid' => 0,
        ]);
    }

    public function test_approved_registration_cannot_be_rejected(): void
    {
        $registration = $this->createPendingRegistration();

        $approveResponse = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.approve',
                    $registration['registration_id']
                )
            );

        $approveResponse->assertOk();

        $rejectResponse = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.reject',
                    $registration['registration_id']
                ),
                [
                    'alasan' => 'Mencoba mengubah keputusan.',
                    'jenis_penolakan' => 'berkas',
                    'invalid_berkas' => ['Akte Kelahiran'],
                ]
            );

        $rejectResponse
            ->assertUnprocessable()
            ->assertJson([
                'success' => false,
                'message' => 'Pendaftaran hanya dapat ditolak ketika masih berstatus pending.',
            ]);

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'approved',
            'alasan_penolakan' => null,
            'diverifikasi_oleh' => 'admin.testing@example.com',
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $registration['student_id'],
            'status' => 'approved',
        ]);

        $this->assertSame(
            3,
            DB::table('berkas')
                ->where(
                    'id_pendaftar',
                    $registration['registration_id']
                )
                ->where('is_valid', 1)
                ->count()
        );
    }

    public function test_rejected_registration_cannot_be_approved(): void
    {
        $registration = $this->createPendingRegistration();

        $rejectResponse = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.reject',
                    $registration['registration_id']
                ),
                [
                    'alasan' => 'Akte kelahiran tidak terbaca.',
                    'jenis_penolakan' => 'berkas',
                    'invalid_berkas' => ['Akte Kelahiran'],
                ]
            );

        $rejectResponse->assertOk();

        $approveResponse = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.approve',
                    $registration['registration_id']
                )
            );

        $approveResponse
            ->assertUnprocessable()
            ->assertJson([
                'success' => false,
                'message' => 'Pendaftaran hanya dapat disetujui ketika masih berstatus pending.',
            ]);

        $this->assertDatabaseHas('pendaftaran', [
            'uid' => $registration['registration_id'],
            'status_pendaftaran' => 'rejected',
            'jenis_penolakan' => 'berkas',
            'alasan_penolakan' => 'Akte kelahiran tidak terbaca.',
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'uid' => $registration['student_id'],
            'status' => 'rejected',
        ]);

        $this->assertDatabaseHas('berkas', [
            'id_pendaftar' => $registration['registration_id'],
            'jenis_berkas' => 'Akte Kelahiran',
            'is_valid' => 0,
        ]);
    }

    private function createPendingRegistration(): array
    {
        $user = User::factory()->create([
            'name' => 'Orang Tua Verifikasi',
            'email' => 'parent.verification@example.com',
        ]);

        $parentId = DB::table('orang_tua')
            ->insertGetId([
                'user_id' => $user->id,
                'no_telp' => '081234567890',
                'nama' => $user->name,
                'alamat' => 'Alamat orang tua pengujian',
                'gaji' => 5000000,
                'pendidikan' => 'S1',
                'unit_sekolah' => 'SD',
                'jumlah_anak' => 1,
            ]);

        $batchId = DB::table('batch_pendaftaran')
            ->insertGetId([
                'cabang' => 'Cabang Pengujian',
                'nama_batch' => 'Batch Verifikasi',
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
                'nama' => 'Anak Verifikasi',
                'tanggal_lahir' => '2018-05-10',
                'nik' => '3174010101010060',
                'alamat' => 'Alamat anak pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => 'pending',
                'nomor_registrasi' => 'REG-VERIFY-00001',
            ]);

        $registrationId = DB::table('pendaftaran')
            ->insertGetId([
                'no_pendaftaran' => 'REG-VERIFY-00001',
                'id_batch_pendaftaran' => $batchId,
                'status_pendaftaran' => 'pending',
                'tanggal_daftar' => now()->toDateString(),
                'calon_siswa_id' => $studentId,
            ]);

        $documentIds = [];

        foreach ([
            'Kartu Keluarga',
            'Akte Kelahiran',
            'Pas Foto',
        ] as $index => $documentType) {
            $documentIds[] = DB::table('berkas')
                ->insertGetId([
                    'id_pendaftar' => $registrationId,
                    'jenis_berkas' => $documentType,
                    'file_url' => 'berkas/testing/document-'
                        . ($index + 1)
                        . '.pdf',
                    'is_valid' => 0,
                ]);
        }

        return [
            'registration_id' => $registrationId,
            'student_id' => $studentId,
            'document_ids' => $documentIds,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function adminSession(): array
    {
        return [
            'staff_login' => true,
            'login_id' => 1,
            'uid_user' => 1,
            'email' => 'admin.testing@example.com',
            'role' => 'admin',
        ];
    }
}