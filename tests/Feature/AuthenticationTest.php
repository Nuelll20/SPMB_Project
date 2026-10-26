<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
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

    public function test_user_can_register(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Orang Tua Pengujian',
            'email' => 'ortu.register@example.com',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $user = DB::table('users')
            ->where('email', 'ortu.register@example.com')
            ->first();

        $this->assertNotNull($user);
        $this->assertSame('Orang Tua Pengujian', $user->name);
        $this->assertTrue(
            Hash::check('Rahasia123!', $user->password)
        );
    }

    public function test_parent_can_login(): void
    {
        $user = User::factory()->create([
            'name' => 'Orang Tua Login',
            'email' => 'ortu.login@example.com',
            'password' => Hash::make('Rahasia123!'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'ortu.login@example.com',
            'password' => 'Rahasia123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('role', 'user');
        $response->assertSessionHas(
            'email',
            'ortu.login@example.com'
        );

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_login(): void
    {
        $staffId = DB::table('user')->insertGetId([
            'uid_user' => null,
            'email' => 'admin.testing@example.com',
            'hash_password' => Hash::make('Rahasia123!'),
            'role' => 'admin',
            'create_at' => now()->toDateString(),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin.testing@example.com',
            'password' => 'Rahasia123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('staff_login', true);
        $response->assertSessionHas('login_id', $staffId);
        $response->assertSessionHas(
            'email',
            'admin.testing@example.com'
        );
        $response->assertSessionHas('role', 'admin');

        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::factory()->create([
            'email' => 'ortu.invalid@example.com',
            'password' => Hash::make('Rahasia123!'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'ortu.invalid@example.com',
            'password' => 'PasswordSalah123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}