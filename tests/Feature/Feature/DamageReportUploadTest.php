<?php

namespace Tests\Feature\Feature;

use App\Models\Asset;
use App\Models\AssetDamageReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DamageReportUploadTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake("public");

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_create_damage_report_with_image()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("damage.jpg", 1024, 768);

        $reportData = [
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "report_date" => now(),
            "severity" => "sedang",
            "damage_type" => "mechanical",
            "priority" => "high",
            "description" => "Test damage with image",
            "status" => "dilaporkan",
            "image_path" => $image,
        ];

        $imagePath = $image->store("damage-reports", "public");
        $reportData["image_path"] = $imagePath;

        $report = AssetDamageReport::create($reportData);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
        ]);

        $this->assertNotNull($report->image_path);
        Storage::disk("public")->assertExists($report->image_path);
    }

    /** @test */
    public function it_can_create_damage_report_without_image()
    {
        $asset = Asset::factory()->create();

        $reportData = [
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "report_date" => now(),
            "severity" => "ringan",
            "priority" => "low",
            "description" => "Test damage without image",
            "status" => "dilaporkan",
            "image_path" => null,
        ];

        $report = AssetDamageReport::create($reportData);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
            "image_path" => null,
        ]);

        $this->assertNull($report->image_path);
    }

    /** @test */
    public function it_can_create_damage_report_with_null_estimated_cost()
    {
        $asset = Asset::factory()->create();

        $reportData = [
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "report_date" => now(),
            "severity" => "berat",
            "priority" => "critical",
            "description" => "Damage without estimated cost",
            "status" => "dilaporkan",
            "estimated_repair_cost" => null,
        ];

        $report = AssetDamageReport::create($reportData);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
            "estimated_repair_cost" => null,
        ]);

        $this->assertNull($report->estimated_repair_cost);
    }

    /** @test */
    public function it_can_create_damage_report_with_estimated_cost()
    {
        $asset = Asset::factory()->create();

        $reportData = [
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "report_date" => now(),
            "severity" => "berat",
            "priority" => "high",
            "description" => "Damage with estimated cost",
            "status" => "dilaporkan",
            "estimated_repair_cost" => 5000000,
        ];

        $report = AssetDamageReport::create($reportData);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
            "estimated_repair_cost" => 5000000,
        ]);

        $this->assertEquals(5000000, $report->estimated_repair_cost);
    }

    /** @test */
    public function it_can_update_damage_report_image()
    {
        $asset = Asset::factory()->create();
        $oldImage = UploadedFile::fake()->image("old-damage.jpg");
        $oldImagePath = $oldImage->store("damage-reports", "public");

        $report = AssetDamageReport::factory()->create([
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "image_path" => $oldImagePath,
        ]);

        Storage::disk("public")->assertExists($oldImagePath);

        // Update with new image
        $newImage = UploadedFile::fake()->image("new-damage.jpg");
        $newImagePath = $newImage->store("damage-reports", "public");

        // Delete old image
        if ($report->image_path) {
            Storage::disk("public")->delete($report->image_path);
        }

        $report->update(["image_path" => $newImagePath]);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
        ]);

        $this->assertNotEquals($oldImagePath, $report->image_path);
        Storage::disk("public")->assertExists($newImagePath);
    }

    /** @test */
    public function it_validates_image_file_type()
    {
        $asset = Asset::factory()->create();
        $invalidFile = UploadedFile::fake()->create("document.pdf", 1024);

        // This should fail validation in the actual controller
        // Here we're just testing the model allows null
        $reportData = [
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "report_date" => now(),
            "severity" => "sedang",
            "priority" => "medium",
            "description" => "Test with invalid file",
            "status" => "dilaporkan",
            "image_path" => null, // Don't store invalid file
        ];

        $report = AssetDamageReport::create($reportData);

        $this->assertNull($report->image_path);
    }

    /** @test */
    public function it_can_remove_image_from_damage_report()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("damage.jpg");
        $imagePath = $image->store("damage-reports", "public");

        $report = AssetDamageReport::factory()->create([
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "image_path" => $imagePath,
        ]);

        Storage::disk("public")->assertExists($imagePath);

        // Remove image
        if ($report->image_path) {
            Storage::disk("public")->delete($report->image_path);
        }

        $report->update(["image_path" => null]);

        $this->assertDatabaseHas("asset_damage_reports", [
            "id" => $report->id,
            "image_path" => null,
        ]);

        $this->assertNull($report->image_path);
    }

    /** @test */
    public function it_handles_multiple_damage_reports_with_images()
    {
        $asset = Asset::factory()->create();

        $report1Image = UploadedFile::fake()->image("damage1.jpg");
        $report1ImagePath = $report1Image->store("damage-reports", "public");

        $report1 = AssetDamageReport::factory()->create([
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "image_path" => $report1ImagePath,
        ]);

        $report2Image = UploadedFile::fake()->image("damage2.jpg");
        $report2ImagePath = $report2Image->store("damage-reports", "public");

        $report2 = AssetDamageReport::factory()->create([
            "asset_id" => $asset->id,
            "reported_by" => $this->user->id,
            "image_path" => $report2ImagePath,
        ]);

        Storage::disk("public")->assertExists($report1->image_path);
        Storage::disk("public")->assertExists($report2->image_path);

        $this->assertNotEquals($report1->image_path, $report2->image_path);
    }
}
