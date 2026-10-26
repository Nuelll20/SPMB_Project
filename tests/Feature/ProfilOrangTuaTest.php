<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfilOrangTuaTest extends TestCase
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

    public function test_guest_cannot_save_parent_profile(): void
    {
        $response = $this->post(route('profil.ortu.store'), [
            'pendidikan' => 'S1',
            'penghasilan' => 5000000,
            'nomor_telepon' => '081234567890',
            'unit_sekolah' => 'TK',
            'alamat' => 'Alamat pengujian orang tua',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseCount('orang_tua', 0);
    }

    public function test_parent_profile_is_updated_without_creating_duplicate(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('profil.ortu.store'), [
                'pendidikan' => 'S1',
                'penghasilan' => 5000000,
                'nomor_telepon' => '081234567890',
                'unit_sekolah' => 'TK',
                'alamat' => 'Alamat pengujian pertama',
            ]);

        $response->assertRedirect(route('form.daftar'));
        $response->assertSessionHas('success');

        $profil = DB::table('orang_tua')
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotNull($profil);

        $response->assertSessionHas(
            'uid_orangtua',
            $profil->uid
        );

        $this->assertSame(
            1,
            DB::table('orang_tua')
                ->where('user_id', $user->id)
                ->count()
        );

        $response = $this
            ->actingAs($user)
            ->post(route('profil.ortu.store'), [
                'pendidikan' => 'S2',
                'penghasilan' => 7000000,
                'nomor_telepon' => '089876543210',
                'unit_sekolah' => 'SD',
                'alamat' => 'Alamat pengujian diperbarui',
            ]);

        $response->assertRedirect(route('form.daftar'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orang_tua', [
            'uid' => $profil->uid,
            'user_id' => $user->id,
            'pendidikan' => 'S2',
            'no_telp' => '089876543210',
            'unit_sekolah' => 'SD',
            'alamat' => 'Alamat pengujian diperbarui',
        ]);

        $this->assertSame(
            1,
            DB::table('orang_tua')
                ->where('user_id', $user->id)
                ->count()
        );
    }
}