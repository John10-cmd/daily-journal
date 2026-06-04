<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_users(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('User Management');

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'New Writer',
                'email' => 'writer@example.com',
                'bio' => 'Testing the admin user module.',
                'password' => 'writer123',
                'password_confirmation' => 'writer123',
            ])
            ->assertRedirect(route('admin.users.index'));

        $writer = User::where('email', 'writer@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('admin.users.update', $writer), [
                'name' => 'Updated Writer',
                'email' => 'writer@example.com',
                'bio' => 'Updated by admin.',
                'is_admin' => '1',
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertTrue($writer->fresh()->is_admin);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $writer))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseMissing('users', ['email' => 'writer@example.com']);
    }

    public function test_regular_user_cannot_open_admin_pages(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }
}
