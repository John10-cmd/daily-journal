<?php

namespace Tests\Feature;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JournalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_register_and_reach_dashboard(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Mara Santos',
            'email' => 'mara@example.com',
            'password' => 'journal123',
            'password_confirmation' => 'journal123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'mara@example.com']);
    }

    public function test_user_can_create_search_update_and_delete_an_entry(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('journal.store'), [
                'title' => 'Focused morning',
                'body' => 'I protected the first hour and finished the hardest task before lunch.',
                'mood' => 'focused',
                'entry_date' => now()->format('Y-m-d'),
                'is_favorite' => '1',
                'tags' => 'work, planning',
            ])
            ->assertRedirect(route('journal.index'));

        $entry = JournalEntry::firstOrFail();
        $this->assertTrue($entry->is_favorite);

        $this->actingAs($user)
            ->get(route('journal.index', ['search' => 'hardest']))
            ->assertOk()
            ->assertSee('Focused morning');

        $this->actingAs($user)
            ->put(route('journal.update', $entry), [
                'title' => 'Focused morning, revised',
                'body' => 'The morning block worked, and I want to repeat it tomorrow.',
                'mood' => 'grateful',
                'entry_date' => now()->format('Y-m-d'),
                'tags' => 'work',
            ])
            ->assertRedirect(route('journal.show', $entry));

        $this->assertDatabaseHas('journal_entries', [
            'id' => $entry->id,
            'title' => 'Focused morning, revised',
            'mood' => 'grateful',
        ]);

        $this->actingAs($user)
            ->delete(route('journal.destroy', $entry))
            ->assertRedirect(route('journal.index'));

        $this->assertDatabaseMissing('journal_entries', ['id' => $entry->id]);
    }

    public function test_user_can_update_profile_with_avatar(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $avatar = UploadedFile::fake()->createWithContent(
            'avatar.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=')
        );

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'bio' => 'Writing a little every day.',
                'avatar' => $avatar,
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
    }

    public function test_user_can_change_password_separately_from_profile_details(): void
    {
        $user = User::factory()->create([
            'password' => 'oldpass123',
        ]);

        $this->actingAs($user)
            ->put(route('profile.password.update'), [
                'current_password' => 'oldpass123',
                'password' => 'newpass123',
                'password_confirmation' => 'newpass123',
            ])
            ->assertRedirect();

        $this->post(route('logout'));

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'newpass123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }
}
