<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TagihanWorkflowTest extends TestCase
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

    public function test_admin_can_create_pending_invoice_with_correct_totals(): void
    {
        $registrationId = $this->createRegistration('approved');

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.tagihan.save',
                    $registrationId
                ),
                $this->invoicePayload()
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Tagihan berhasil disimpan ke database.',
            ]);

        $invoiceId = (int) $response->json('tagihan_id');

        $this->assertGreaterThan(0, $invoiceId);

        $invoice = DB::table('tagihan')
            ->where('uid', $invoiceId)
            ->first();

        $this->assertNotNull($invoice);
        $this->assertSame($registrationId, (int) $invoice->uid_pendaftaran);
        $this->assertSame('pending', $invoice->status_tagihan);
        $this->assertSame(1500000.0, (float) $invoice->subtotal_tagihan);
        $this->assertSame(100000.0, (float) $invoice->diskon_tagihan);
        $this->assertSame(1400000.0, (float) $invoice->total_tagihan);
        $this->assertSame(
            'admin.testing@example.com',
            $invoice->dibuat_oleh
        );

        $components = DB::table('komponen_tagihan')
            ->where('uid_tagihan', $invoiceId)
            ->orderBy('urutan')
            ->get();

        $this->assertCount(2, $components);

        $this->assertSame(
            'Uang Pangkal',
            $components[0]->nama_komponen
        );
        $this->assertSame(1.0, (float) $components[0]->qty);
        $this->assertSame(1000000.0, (float) $components[0]->nominal);
        $this->assertSame(1000000.0, (float) $components[0]->subtotal);

        $this->assertSame(
            'Seragam',
            $components[1]->nama_komponen
        );
        $this->assertSame(2.0, (float) $components[1]->qty);
        $this->assertSame(250000.0, (float) $components[1]->nominal);
        $this->assertSame(500000.0, (float) $components[1]->subtotal);
    }

    public function test_admin_update_replaces_pending_invoice_components(): void
    {
        $registrationId = $this->createRegistration('approved');

        $firstInvoiceId = $this->savePendingInvoice(
            $registrationId
        );

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.tagihan.save',
                    $registrationId
                ),
                [
                    'diskon' => 50000,
                    'admin_pembuat' => 'admin.testing@example.com',
                    'status_tagihan' => 'pending',
                    'items' => [
                        [
                            'nama_komponen' => 'SPP',
                            'qty' => 3,
                            'nominal' => 200000,
                        ],
                    ],
                ]
            );

        $response->assertOk();

        $this->assertSame(
            $firstInvoiceId,
            (int) $response->json('tagihan_id')
        );

        $this->assertSame(
            1,
            DB::table('tagihan')
                ->where('uid_pendaftaran', $registrationId)
                ->count()
        );

        $invoice = DB::table('tagihan')
            ->where('uid', $firstInvoiceId)
            ->first();

        $this->assertSame(600000.0, (float) $invoice->subtotal_tagihan);
        $this->assertSame(50000.0, (float) $invoice->diskon_tagihan);
        $this->assertSame(550000.0, (float) $invoice->total_tagihan);
        $this->assertSame('pending', $invoice->status_tagihan);

        $this->assertSame(
            1,
            DB::table('komponen_tagihan')
                ->where('uid_tagihan', $firstInvoiceId)
                ->count()
        );

        $this->assertDatabaseHas('komponen_tagihan', [
            'uid_tagihan' => $firstInvoiceId,
            'nama_komponen' => 'SPP',
            'urutan' => 1,
        ]);

        $this->assertDatabaseMissing('komponen_tagihan', [
            'uid_tagihan' => $firstInvoiceId,
            'nama_komponen' => 'Uang Pangkal',
        ]);
    }

    public function test_invoice_cannot_be_created_for_unapproved_registration(): void
    {
        $registrationId = $this->createRegistration('pending');

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.tagihan.save',
                    $registrationId
                ),
                $this->invoicePayload()
            );

        $response
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Tagihan hanya bisa dibuat untuk pendaftar yang sudah approved.',
            ]);

        $this->assertDatabaseMissing('tagihan', [
            'uid_pendaftaran' => $registrationId,
        ]);
    }

    public function test_non_admin_cannot_create_invoice(): void
    {
        $registrationId = $this->createRegistration('approved');

        $response = $this->postJson(
            route(
                'admin.pendaftaran.tagihan.save',
                $registrationId
            ),
            $this->invoicePayload()
        );

        $response
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Akses admin ditolak. Silakan login sebagai admin terlebih dahulu.',
            ]);

        $this->assertDatabaseMissing('tagihan', [
            'uid_pendaftaran' => $registrationId,
        ]);
    }

    public function test_kepsek_can_finalize_invoice_and_replace_components(): void
    {
        $registrationId = $this->createRegistration('approved');
        $invoiceId = $this->savePendingInvoice($registrationId);

        $response = $this
            ->withSession($this->kepsekSession())
            ->postJson(
                route(
                    'kepsek.invoice.approve',
                    $invoiceId
                ),
                $this->approvalPayload()
            );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Invoice final berhasil disetujui kepala sekolah. Orang tua akan otomatis melihat invoice terbaru.',
            ]);

        $invoice = DB::table('tagihan')
            ->where('uid', $invoiceId)
            ->first();

        $this->assertNotNull($invoice);
        $this->assertSame('valid', $invoice->status_tagihan);
        $this->assertSame(1800000.0, (float) $invoice->subtotal_tagihan);
        $this->assertSame(200000.0, (float) $invoice->diskon_tagihan);
        $this->assertSame(1600000.0, (float) $invoice->total_tagihan);
        $this->assertSame(
            'Disetujui setelah penyesuaian biaya.',
            $invoice->catatan_kepsek
        );
        $this->assertSame(
            'kepsek.testing@example.com',
            $invoice->disetujui_oleh
        );

        $components = DB::table('komponen_tagihan')
            ->where('uid_tagihan', $invoiceId)
            ->orderBy('urutan')
            ->get();

        $this->assertCount(2, $components);
        $this->assertSame(
            'Biaya Pendidikan',
            $components[0]->nama_komponen
        );
        $this->assertSame(
            'Seragam Final',
            $components[1]->nama_komponen
        );
    }

    public function test_non_kepsek_cannot_finalize_invoice(): void
    {
        $registrationId = $this->createRegistration('approved');
        $invoiceId = $this->savePendingInvoice($registrationId);

        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'kepsek.invoice.approve',
                    $invoiceId
                ),
                $this->approvalPayload()
            );

        $response
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Akses kepala sekolah ditolak. Silakan login sebagai kepala sekolah terlebih dahulu.',
            ]);

        $this->assertDatabaseHas('tagihan', [
            'uid' => $invoiceId,
            'status_tagihan' => 'pending',
            'disetujui_oleh' => null,
        ]);
    }

    public function test_final_invoice_cannot_be_modified_or_approved_again(): void
    {
        $registrationId = $this->createRegistration('approved');
        $invoiceId = $this->savePendingInvoice($registrationId);

        $approvalResponse = $this
            ->withSession($this->kepsekSession())
            ->postJson(
                route(
                    'kepsek.invoice.approve',
                    $invoiceId
                ),
                $this->approvalPayload()
            );

        $approvalResponse->assertOk();

        $secondApproval = $this
            ->withSession($this->kepsekSession())
            ->postJson(
                route(
                    'kepsek.invoice.approve',
                    $invoiceId
                ),
                $this->approvalPayload()
            );

        $secondApproval
            ->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'Invoice ini sudah final dan tidak bisa diubah lagi.',
            ]);

        $adminUpdate = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.tagihan.save',
                    $registrationId
                ),
                $this->invoicePayload()
            );

        $adminUpdate
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Invoice sudah menjadi final approval kepala sekolah. Admin SPMB tidak dapat mengubah invoice ini lagi.',
            ]);

        $this->assertDatabaseHas('tagihan', [
            'uid' => $invoiceId,
            'status_tagihan' => 'valid',
            'disetujui_oleh' => 'kepsek.testing@example.com',
        ]);
    }

    private function createRegistration(string $status): int
    {
        $user = User::factory()->create([
            'name' => 'Orang Tua Tagihan',
            'email' => 'parent.invoice@example.com',
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
                'nama_batch' => 'Batch Tagihan',
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
                'nama' => 'Anak Tagihan',
                'tanggal_lahir' => '2018-05-10',
                'nik' => '3174010101010070',
                'alamat' => 'Alamat anak pengujian',
                'agama' => 'kristen',
                'golongan_darah' => 'O',
                'uid_orangtua' => $parentId,
                'status' => $status,
                'nomor_registrasi' => 'REG-INVOICE-00001',
            ]);

        return DB::table('pendaftaran')
            ->insertGetId([
                'no_pendaftaran' => 'REG-INVOICE-00001',
                'id_batch_pendaftaran' => $batchId,
                'status_pendaftaran' => $status,
                'diverifikasi_oleh' => $status === 'approved'
                    ? 'admin.testing@example.com'
                    : null,
                'tanggal_daftar' => now()->toDateString(),
                'tanggal_verifikasi' => $status === 'approved'
                    ? now()
                    : null,
                'calon_siswa_id' => $studentId,
            ]);
    }

    private function savePendingInvoice(
        int $registrationId
    ): int {
        $response = $this
            ->withSession($this->adminSession())
            ->postJson(
                route(
                    'admin.pendaftaran.tagihan.save',
                    $registrationId
                ),
                $this->invoicePayload()
            );

        $response->assertOk();

        return (int) $response->json('tagihan_id');
    }

    /**
     * @return array<string, mixed>
     */
    private function invoicePayload(): array
    {
        return [
            'diskon' => 100000,
            'admin_pembuat' => 'admin.testing@example.com',
            'status_tagihan' => 'pending',
            'items' => [
                [
                    'nama_komponen' => 'Uang Pangkal',
                    'qty' => 1,
                    'nominal' => 1000000,
                ],
                [
                    'nama_komponen' => 'Seragam',
                    'qty' => 2,
                    'nominal' => 250000,
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function approvalPayload(): array
    {
        return [
            'catatan_kepsek'
            => 'Disetujui setelah penyesuaian biaya.',
            'diskon' => 200000,
            'items' => [
                [
                    'nama_komponen' => 'Biaya Pendidikan',
                    'qty' => 1,
                    'nominal' => 1200000,
                ],
                [
                    'nama_komponen' => 'Seragam Final',
                    'qty' => 2,
                    'nominal' => 300000,
                ],
            ],
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

    /**
     * @return array<string, mixed>
     */
    private function kepsekSession(): array
    {
        return [
            'staff_login' => true,
            'login_id' => 2,
            'uid_user' => 2,
            'email' => 'kepsek.testing@example.com',
            'role' => 'kepsek',
        ];
    }
}