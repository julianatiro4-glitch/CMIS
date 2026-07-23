<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Models\Division;
use App\Models\MaintenanceRecord;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOperationsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $itStaff;
    private User $viewer;
    private Asset $asset;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users with different roles
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        $this->itStaff = User::create([
            'name' => 'IT Staff User',
            'email' => 'itstaff@test.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_IT_STAFF,
        ]);

        $this->viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@test.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_VIEWER,
        ]);

        // Create relations
        $category = Category::create(['name' => 'Laptops', 'description' => 'Notebook computers']);
        $location = Location::create(['name' => 'IT Office', 'description' => '4th Floor']);
        $division = Division::create(['code' => 'PSD', 'name' => 'Projects Division', 'location_id' => $location->id]);

        // Create asset
        $this->asset = Asset::create([
            'asset_tag' => 'CMP-0001',
            'name' => 'Developer Workstation',
            'category_id' => $category->id,
            'location_id' => $location->id,
            'division_id' => $division->id,
            'status' => 'available',
            'condition' => 'good',
        ]);
    }

    /**
     * Test route permissions.
     */
    public function test_route_access_permissions(): void
    {
        // Guests should be redirected
        $this->get('/maintenance')->assertRedirect(route('login'));
        $this->get('/activity-logs')->assertRedirect(route('login'));

        // Viewers can view list but cannot modify maintenance tickets
        $this->actingAs($this->viewer);
        $this->get('/maintenance')->assertOk();
        $this->get('/activity-logs')->assertOk();
        $this->get('/assets/create')->assertStatus(403);

        // IT Staff and Admins can access forms
        $this->actingAs($this->itStaff);
        $this->get('/maintenance/create')->assertOk();
        $this->get('/assets/create')->assertOk();
        $this->get("/assets/{$this->asset->id}")->assertOk();
        $this->get('/assets')->assertOk();
    }

    /**
     * Test maintenance workflow.
     */
    public function test_maintenance_ticket_lifecycle(): void
    {
        $this->actingAs($this->itStaff);

        // 1. Create Maintenance Ticket
        $ticketData = [
            'asset_id' => $this->asset->id,
            'technician' => 'John Doe Repair Shop',
            'issue_description' => 'Broken screen hinge',
            'status' => 'open',
            'opened_at' => now()->format('Y-m-d H:i:s'),
        ];

        $response = $this->post('/maintenance', $ticketData);
        $response->assertRedirect(route('maintenance.index'));

        // Verify asset status changes to 'in_repair'
        $this->asset->refresh();
        $this->assertEquals('in_repair', $this->asset->status);

        // Verify record created
        $ticket = MaintenanceRecord::where('asset_id', $this->asset->id)->first();
        $this->assertNotNull($ticket);
        $this->assertEquals('open', $ticket->status);

        // Verify activity log registered
        $log = ActivityLog::where('model_type', MaintenanceRecord::class)->first();
        $this->assertNotNull($log);
        $this->assertEquals('created', $log->action);

        // 2. Update to Resolved
        $updateData = [
            'asset_id' => $this->asset->id,
            'technician' => 'John Doe Repair Shop',
            'issue_description' => 'Broken screen hinge',
            'status' => 'resolved',
            'opened_at' => $ticket->opened_at->format('Y-m-d H:i:s'),
            'cost' => 1500.00,
            'resolution_notes' => 'Replaced hinges and tested ok.',
        ];

        $response = $this->put("/maintenance/{$ticket->id}", $updateData);
        $response->assertRedirect(route('maintenance.index'));

        // Verify asset status changes back to 'available'
        $this->asset->refresh();
        $this->assertEquals('available', $this->asset->status);

        // Verify ticket marked resolved
        $ticket->refresh();
        $this->assertEquals('resolved', $ticket->status);
        $this->assertEquals(1500.00, $ticket->cost);
        $this->assertNotNull($ticket->resolved_at);

        // Verify update log registered
        $updateLog = ActivityLog::where('model_type', MaintenanceRecord::class)->where('action', 'updated')->first();
        $this->assertNotNull($updateLog);
    }

    /**
     * Test logout is matchable and CSRF exempt.
     */
    public function test_logout_exempt_from_csrf(): void
    {
        $this->actingAs($this->admin);

        // Hitting logout via POST without a CSRF token should log the user out and redirect to login
        // (Previously it would throw a 419 Page Expired)
        $response = $this->post('/logout');
        
        $response->assertRedirect(route('login'));
        $this->assertFalse(auth()->check());
    }
}
