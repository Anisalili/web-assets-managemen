<?php

namespace Tests\Feature\Feature;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssetImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake("public");

        // Seed once and store user
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->user = User::first();
        $this->assertNotNull($this->user, "User not found after seeding");
    }

    /** @test */
    public function it_can_upload_image_when_creating_asset()
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");

        $category = AssetCategory::factory()->create();

        $file = UploadedFile::fake()->image("asset.jpg", 200, 200)->size(1024);

        $response = $this->actingAs($user)->post(route("assets.store"), [
            "asset_code" => "TEST-001",
            "name" => "Test Asset",
            "category_id" => $category->id,
            "status" => "aktif",
            "image" => $file,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route("assets.index"));
        $response->assertSessionHas("success");

        $asset = Asset::where("asset_code", "TEST-001")->first();
        $this->assertNotNull($asset->image_path);
        Storage::disk("public")->assertExists($asset->image_path);
    }

    /** @test */
    public function it_can_update_asset_with_new_image()
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");
        $category = AssetCategory::factory()->create();

        $asset = Asset::factory()->create([
            "category_id" => $category->id,
            "image_path" => null,
        ]);

        $file = UploadedFile::fake()
            ->image("new-asset.jpg", 200, 200)
            ->size(1024);

        $response = $this->actingAs($user)->put(
            route("assets.update", $asset),
            [
                "asset_code" => $asset->asset_code,
                "name" => $asset->name,
                "category_id" => $category->id,
                "status" => "aktif",
                "image" => $file,
            ],
        );

        $response->assertRedirect(route("assets.index"));

        $asset->refresh();
        $this->assertNotNull($asset->image_path);
        Storage::disk("public")->assertExists($asset->image_path);
    }

    /** @test */
    public function it_deletes_old_image_when_uploading_new_one()
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");
        $category = AssetCategory::factory()->create();

        $oldFile = UploadedFile::fake()->image("old.jpg");
        $oldPath = $oldFile->store("assets", "public");

        $asset = Asset::factory()->create([
            "category_id" => $category->id,
            "image_path" => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image("new.jpg", 200, 200)->size(1024);

        $this->actingAs($user)->put(route("assets.update", $asset), [
            "asset_code" => $asset->asset_code,
            "name" => $asset->name,
            "category_id" => $category->id,
            "status" => "aktif",
            "image" => $newFile,
        ]);

        Storage::disk("public")->assertMissing($oldPath);

        $asset->refresh();
        Storage::disk("public")->assertExists($asset->image_path);
    }

    /** @test */
    public function it_validates_image_file_type()
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");
        $category = AssetCategory::factory()->create();

        $file = UploadedFile::fake()->create("document.pdf", 1024);

        $response = $this->actingAs($user)->post(route("assets.store"), [
            "asset_code" => "TEST-002",
            "name" => "Test Asset",
            "category_id" => $category->id,
            "status" => "aktif",
            "image" => $file,
        ]);

        $response->assertSessionHasErrors("image");
    }

    /** @test */
    public function it_validates_image_file_size()
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::first();
        $this->assertNotNull($user, "User not found after seeding");
        $category = AssetCategory::factory()->create();

        $file = UploadedFile::fake()->image("large.jpg")->size(3000); // 3MB

        $response = $this->actingAs($user)->post(route("assets.store"), [
            "asset_code" => "TEST-003",
            "name" => "Test Asset",
            "category_id" => $category->id,
            "status" => "aktif",
            "image" => $file,
        ]);

        $response->assertSessionHasErrors("image");
    }
}
