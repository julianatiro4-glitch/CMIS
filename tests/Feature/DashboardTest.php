<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_attention_summary(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Needs attention');
        $response->assertSee('Open tickets');
    }
}
