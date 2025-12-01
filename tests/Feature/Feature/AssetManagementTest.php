<?php

namespace Tests\Feature\Feature;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create user with permissions
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_create_asset_with_private_owner()
    {
        $category = AssetCategory::factory()->create();
        $room = Room::factory()->create();

        $assetData = [
            "asset_code" => "AST-TEST-001",
            "name" => "Test Asset",
            "category_id" => $category->id,
            "room_id" => $room->id,
            "status" => "aktif",
            "owner" => "Bagian IT",
            "private_owner" => "John Doe",
            "purchase_date" => "2024-01-01",
            "value" => 5000000,
            "notes" => "Test notes",
        ];

        $asset = Asset::create($assetData);

        $this->assertDatabaseHas("assets", [
            "asset_code" => "AST-TEST-001",
            "private_owner" => "John Doe",
        ]);

        $this->assertEquals("John Doe", $asset->private_owner);
    }

    /** @test */
    public function it_can_create_asset_without_private_owner()
    {
        $category = AssetCategory::factory()->create();
        $room = Room::factory()->create();

        $assetData = [
            "asset_code" => "AST-TEST-002",
            "name" => "Test Asset Without Private Owner",
            "category_id" => $category->id,
            "room_id" => $room->id,
            "status" => "aktif",
            "owner" => "Bagian Umum",
            "private_owner" => null,
        ];

        $asset = Asset::create($assetData);

        $this->assertDatabaseHas("assets", [
            "asset_code" => "AST-TEST-002",
            "private_owner" => null,
        ]);

        $this->assertNull($asset->private_owner);
    }

    /** @test */
    public function it_can_create_asset_with_null_value()
    {
        $category = AssetCategory::factory()->create();
        $room = Room::factory()->create();

        $assetData = [
            "asset_code" => "AST-TEST-003",
            "name" => "Asset Without Value",
            "category_id" => $category->id,
            "room_id" => $room->id,
            "status" => "aktif",
            "value" => null,
        ];

        $asset = Asset::create($assetData);

        $this->assertDatabaseHas("assets", [
            "asset_code" => "AST-TEST-003",
            "value" => null,
        ]);

        $this->assertNull($asset->value);
    }

    /** @test */
    public function it_can_update_asset_with_private_owner()
    {
        $asset = Asset::factory()->create([
            "private_owner" => null,
        ]);

        $asset->update([
            "private_owner" => "Jane Smith",
        ]);

        $this->assertDatabaseHas("assets", [
            "id" => $asset->id,
            "private_owner" => "Jane Smith",
        ]);
    }

    /** @test */
    public function it_can_remove_private_owner_from_asset()
    {
        $asset = Asset::factory()->create([
            "private_owner" => "John Doe",
        ]);

        $asset->update([
            "private_owner" => null,
        ]);

        $this->assertDatabaseHas("assets", [
            "id" => $asset->id,
            "private_owner" => null,
        ]);
    }

    /** @test */
    public function it_can_create_asset_without_room()
    {
        $category = AssetCategory::factory()->create();

        $assetData = [
            "asset_code" => "AST-TEST-004",
            "name" => "Asset Without Room",
            "category_id" => $category->id,
            "room_id" => null,
            "status" => "aktif",
        ];

        $asset = Asset::create($assetData);

        $this->assertDatabaseHas("assets", [
            "asset_code" => "AST-TEST-004",
            "room_id" => null,
        ]);

        $this->assertNull($asset->room_id);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Asset::create([
            "name" => "Test Asset",
            // Missing required fields: asset_code, category_id, status
        ]);
    }

    /** @test */
    public function asset_code_must_be_unique()
    {
        $category = AssetCategory::factory()->create();

        Asset::factory()->create([
            "asset_code" => "AST-UNIQUE-001",
            "category_id" => $category->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Asset::create([
            "asset_code" => "AST-UNIQUE-001", // Duplicate
            "name" => "Duplicate Asset",
            "category_id" => $category->id,
            "status" => "aktif",
        ]);
    }

    /** @test */
    public function it_can_have_multiple_assets_with_same_private_owner()
    {
        $category = AssetCategory::factory()->create();

        $asset1 = Asset::factory()->create([
            "category_id" => $category->id,
            "private_owner" => "John Doe",
        ]);

        $asset2 = Asset::factory()->create([
            "category_id" => $category->id,
            "private_owner" => "John Doe",
        ]);

        $this->assertEquals("John Doe", $asset1->private_owner);
        $this->assertEquals("John Doe", $asset2->private_owner);
    }
}
