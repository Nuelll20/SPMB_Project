<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PendaftaranAnakTest extends TestCase
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

    public function test_catholic_student_requires_baptism_certificate(): void
    {
        $user = $this->createUserWithParentProfile();
        $this->createActiveBatch();

        $response = $this
            ->actingAs($user)
            ->from(route('form.daftar'))
            ->post(
                route('form.daftar.store'),
                $this->registrationData(
                    'katolik',
                    '3174010101010001',
                    false
                )
            );

        $response->assertRedirect(route('form.daftar'));
        $response->assertSessionHasErrors('surat_baptis');

        $this->assertDatabaseMissing('calon_siswa', [
            'nik' => '3174010101010001',
        ]);

        $this->assertSame(
            [],
            Storage::disk('local')->allFiles()
        );
    }

    public function test_christian_student_can_register_without_baptism_certificate(): void
    {
        $user = $this->createUserWithParentProfile();
        $batchId = $this->createActiveBatch();

        $response = $this
            ->actingAs($user)
            ->post(
                route('form.daftar.store'),
                $this->registrationData(
                    'kristen',
                    '3174010101010002',
                    false
                )
            );

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $student = DB::table('calon_siswa')
            ->where('nik', '3174010101010002')
            ->first();

        $this->assertNotNull($student);
        $this->assertSame('kristen', $student->agama);
        $this->assertSame('pending', $student->status);

        $registration = DB::table('pendaftaran')
            ->where('calon_siswa_id', $student->uid)
            ->first();

        $this->assertNotNull($registration);
        $this->assertSame(
            $batchId,
            (int) $registration->id_batch_pendaftaran
        );
        $this->assertSame(
            'pending',
            $registration->status_pendaftaran
        );

        $files = DB::table('berkas')
            ->where('id_pendaftar', $registration->uid)
            ->get();

        $this->assertCount(4, $files);
        $this->assertFalse(
            $files->contains(
                'jenis_berkas',
                'Surat Baptis'
            )
        );

        foreach ($files as $file) {
            Storage::disk('local')
                ->assertExists($file->file_url);
        }
    }

    public function test_catholic_student_can_register_with_baptism_certificate(): void
    {
        $user = $this->createUserWithParentProfile();
        $this->createActiveBatch();

        $response = $this
            ->actingAs($user)
            ->post(
                route('form.daftar.store'),
                $this->registrationData(
                    'katolik',
                    '3174010101010003',
                    true
                )
            );

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $student = DB::table('calon_siswa')
            ->where('nik', '3174010101010003')
            ->first();

        $this->assertNotNull($student);
        $this->assertSame('katolik', $student->agama);
        $this->assertSame('pending', $student->status);

        $registration = DB::table('pendaftaran')
            ->where('calon_siswa_id', $student->uid)
            ->first();

        $this->assertNotNull($registration);

        $files = DB::table('berkas')
            ->where('id_pendaftar', $registration->uid)
            ->get();

        $this->assertCount(5, $files);
        $this->assertTrue(
            $files->contains(
                'jenis_berkas',
                'Surat Baptis'
            )
        );

        foreach ($files as $file) {
            Storage::disk('local')
                ->assertExists($file->file_url);
        }
    }

    private function createUserWithParentProfile(): User
    {
        $user = User::factory()->create([
            'name' => 'Orang Tua Pendaftaran',
            'email' => 'pendaftaran.testing@example.com',
        ]);

        DB::table('orang_tua')->insert([
            'user_id' => $user->id,
            'no_telp' => '081234567890',
            'nama' => $user->name,
            'alamat' => 'Alamat orang tua pengujian',
            'gaji' => 5000000,
            'pendidikan' => 'S1',
            'unit_sekolah' => 'SD',
            'jumlah_anak' => 1,
        ]);

        return $user;
    }

    private function createActiveBatch(): int
    {
        return DB::table('batch_pendaftaran')
            ->insertGetId([
                'cabang' => 'Cabang Pengujian',
                'nama_batch' => 'Batch Pengujian',
                'tanggal_buka' => now()->subDay()->toDateString(),
                'tanggal_tutup' => now()->addDay()->toDateString(),
                'kuota' => 10,
                'is_active' => 1,
                'created_at' => now()->toDateString(),
                'dibuat_oleh' => 'PHPUnit',
            ]);
    }

    private function registrationData(
        string $religion,
        string $nik,
        bool $includeBaptismCertificate
    ): array {
        $data = [
            'nama_lengkap' => 'Anak Pengujian',
            'nik' => $nik,
            'tanggal_lahir' => '2018-05-10',
            'gol_darah' => 'O',
            'agama' => $religion,
            'alamat' => 'Alamat anak pengujian',
            'tempat_lahir' => 'Jakarta',

            'kartu_keluarga' => UploadedFile::fake()->create(
                'kartu-keluarga.pdf',
                100,
                'application/pdf'
            ),
            'akte_kelahiran' => UploadedFile::fake()->create(
                'akte-kelahiran.pdf',
                100,
                'application/pdf'
            ),
            'ktp_ortu' => UploadedFile::fake()->create(
                'ktp-orang-tua.pdf',
                100,
                'application/pdf'
            ),
            'pas_foto' => UploadedFile::fake()->create(
                'pas-foto.jpg',
                100,
                'image/jpeg'
            ),
        ];

        if ($includeBaptismCertificate) {
            $data['surat_baptis'] = UploadedFile::fake()->create(
                'surat-baptis.pdf',
                100,
                'application/pdf'
            );
        }

        return $data;
    }
}