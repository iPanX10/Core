<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create();

        $user->forceFill([
            'role' => 'user',
        ])->save();

        $panel = Filament::getPanel('admin');

        $this->assertFalse(
            $user->canAccessPanel($panel)
        );
    }

    public function test_admin_role_is_allowed_to_access_admin_panel(): void
    {
        $user = User::factory()->create();

        $user->forceFill([
            'role' => 'admin',
        ])->save();

        $panel = Filament::getPanel('admin');

        $this->assertTrue(
            $user->canAccessPanel($panel)
        );
    }
}