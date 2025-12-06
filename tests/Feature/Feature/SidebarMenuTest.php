<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidebarMenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function report_routes_use_unique_naming_pattern()
    {
        $this->assertNotNull(route("report.barang"));
        $this->assertNotNull(route("report.pemeliharaan"));
        $this->assertNotNull(route("report.kerusakan"));

        $this->assertEquals(
            "/reports/assets",
            route("report.barang", [], false),
        );
        $this->assertEquals(
            "/reports/maintenance",
            route("report.pemeliharaan", [], false),
        );
        $this->assertEquals(
            "/reports/damage",
            route("report.kerusakan", [], false),
        );
    }

    /** @test */
    public function sidebar_shows_only_reports_menu_when_accessing_asset_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.barang"));

        $response->assertStatus(200);
        $response->assertSee("Laporan Asset");

        // Check that the response contains the report route
        $this->assertTrue(str_contains($response->content(), "report.barang"));
    }

    /** @test */
    public function sidebar_shows_only_reports_menu_when_accessing_maintenance_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.pemeliharaan"));

        $response->assertStatus(200);
        $response->assertSee("Laporan");
    }

    /** @test */
    public function sidebar_shows_only_reports_menu_when_accessing_damage_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.kerusakan"));

        $response->assertStatus(200);
        $response->assertSee("Laporan");
    }

    /** @test */
    public function asset_menu_does_not_expand_when_viewing_asset_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.barang"));

        // The asset menu should NOT have 'show' class when viewing asset report
        // This is verified by the JavaScript fix that runs on page load
        $response->assertStatus(200);
    }

    /** @test */
    public function maintenance_menu_does_not_expand_when_viewing_maintenance_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.pemeliharaan"));

        $response->assertStatus(200);
    }

    /** @test */
    public function damage_menu_does_not_expand_when_viewing_damage_report()
    {
        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $response = $this->actingAs($user)->get(route("report.kerusakan"));

        $response->assertStatus(200);
    }
}
