<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationSecurityTest extends TestCase
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

    public function test_staff_login_regenerates_session(): void
    {
        DB::table('user')->insert([
            'uid_user' => null,
            'email' => 'secure.admin@example.com',
            'hash_password' => Hash::make('Rahasia123!'),
            'role' => 'admin',
            'create_at' => now()->toDateString(),
        ]);

        $session = $this->app['session.store'];
        $session->start();

        $previousSessionId = $session->getId();

        $response = $this
            ->withSession([
                'before_login' => true,
            ])
            ->post(route('login'), [
                'email' => 'secure.admin@example.com',
                'password' => 'Rahasia123!',
            ]);

        $response
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('staff_login', true)
            ->assertSessionHas('role', 'admin');

        $this->assertNotSame(
            $previousSessionId,
            $session->getId(),
            'Session ID staf harus berubah setelah login.'
        );
    }

    public function test_unknown_staff_role_is_rejected(): void
    {
        DB::table('user')->insert([
            'uid_user' => null,
            'email' => 'unknown.role@example.com',
            'hash_password' => Hash::make('Rahasia123!'),
            'role' => 'auditor',
            'create_at' => now()->toDateString(),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'unknown.role@example.com',
            'password' => 'Rahasia123!',
        ]);

        $response
            ->assertSessionHasErrors('email')
            ->assertSessionMissing('staff_login')
            ->assertSessionMissing('role');

        $this->assertGuest();
    }

    public function test_parent_cannot_register_with_staff_email(): void
    {
        DB::table('user')->insert([
            'uid_user' => null,
            'email' => 'shared.staff@example.com',
            'hash_password' => Hash::make('Rahasia123!'),
            'role' => 'admin',
            'create_at' => now()->toDateString(),
        ]);

        $response = $this->post(
            route('register.store'),
            [
                'name' => 'Orang Tua Bentrok',
                'email' => 'shared.staff@example.com',
                'password' => 'Rahasia123!',
                'password_confirmation' => 'Rahasia123!',
            ]
        );

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', [
            'email' => 'shared.staff@example.com',
        ]);
    }

    public function test_staff_cannot_use_parent_email(): void
    {
        User::factory()->create([
            'email' => 'shared.parent@example.com',
        ]);

        $response = $this
            ->withSession([
                'role' => 'kepsek',
                'staff_login' => true,
                'email' => 'kepsek.testing@example.com',
            ])
            ->post(route('kepsek.staf.store'), [
                'nama' => 'Admin Bentrok',
                'email' => 'shared.parent@example.com',
                'password' => 'Rahasia123!',
                'password_confirmation' => 'Rahasia123!',
            ]);

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('user', [
            'email' => 'shared.parent@example.com',
        ]);
    }

    public function test_staff_password_requires_confirmation(): void
    {
        $response = $this
            ->withSession([
                'role' => 'kepsek',
                'staff_login' => true,
                'email' => 'kepsek.testing@example.com',
            ])
            ->post(route('kepsek.staf.store'), [
                'nama' => 'Admin Konfirmasi',
                'email' => 'confirmation.admin@example.com',
                'password' => 'Rahasia123!',
                'password_confirmation' => 'Berbeda123!',
            ]);

        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('user', [
            'email' => 'confirmation.admin@example.com',
        ]);
    }

    public function test_kepsek_can_create_staff_with_normalized_email(): void
    {
        $response = $this
            ->withSession([
                'role' => 'kepsek',
                'staff_login' => true,
                'email' => 'kepsek.testing@example.com',
            ])
            ->post(route('kepsek.staf.store'), [
                'nama' => 'Admin Baru',
                'email' => 'ADMIN.BARU@EXAMPLE.COM',
                'password' => 'Rahasia123!',
                'password_confirmation' => 'Rahasia123!',
            ]);

        $response
            ->assertRedirect(
                route('kepsek.dashboard', [
                    'tab' => 'staf',
                ])
            )
            ->assertSessionHas('success');

        $account = DB::table('user')
            ->where(
                'email',
                'admin.baru@example.com'
            )
            ->first();

        $this->assertNotNull($account);
        $this->assertSame('admin', $account->role);
        $this->assertTrue(
            Hash::check(
                'Rahasia123!',
                $account->hash_password
            )
        );

        $this->assertDatabaseHas('staf_spmb', [
            'uid' => $account->uid_user,
            'nama' => 'Admin Baru',
            'jabatan' => 'admin',
        ]);
    }
}