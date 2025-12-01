<?php

namespace Tests\Feature\Feature;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MaintenanceScheduleUploadTest extends TestCase
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
    public function it_can_create_maintenance_schedule_with_image()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("etiket.jpg", 800, 600);

        $imagePath = $image->store("maintenance-schedules", "public");

        $scheduleData = [
            "asset_id" => $asset->id,
            "scheduled_date" => now()->addDays(7),
            "frequency" => "bulanan",
            "description" => "Scheduled maintenance with etiket image",
            "image_path" => $imagePath,
            "status" => "terjadwal",
        ];

        $schedule = MaintenanceSchedule::create($scheduleData);

        $this->assertDatabaseHas("maintenance_schedules", [
            "id" => $schedule->id,
        ]);

        $this->assertNotNull($schedule->image_path);
        Storage::disk("public")->assertExists($schedule->image_path);
    }

    /** @test */
    public function it_can_create_maintenance_schedule_without_image()
    {
        $asset = Asset::factory()->create();

        $scheduleData = [
            "asset_id" => $asset->id,
            "scheduled_date" => now()->addDays(14),
            "frequency" => "mingguan",
            "description" => "Scheduled maintenance without image",
            "image_path" => null,
            "status" => "terjadwal",
        ];

        $schedule = MaintenanceSchedule::create($scheduleData);

        $this->assertDatabaseHas("maintenance_schedules", [
            "id" => $schedule->id,
            "image_path" => null,
        ]);

        $this->assertNull($schedule->image_path);
    }

    /** @test */
    public function it_can_update_maintenance_schedule_image()
    {
        $asset = Asset::factory()->create();
        $oldImage = UploadedFile::fake()->image("old-etiket.jpg");
        $oldImagePath = $oldImage->store("maintenance-schedules", "public");

        $schedule = MaintenanceSchedule::factory()->create([
            "asset_id" => $asset->id,
            "image_path" => $oldImagePath,
        ]);

        Storage::disk("public")->assertExists($oldImagePath);

        // Update with new image
        $newImage = UploadedFile::fake()->image("new-etiket.jpg");
        $newImagePath = $newImage->store("maintenance-schedules", "public");

        // Delete old image
        if ($schedule->image_path) {
            Storage::disk("public")->delete($schedule->image_path);
        }

        $schedule->update(["image_path" => $newImagePath]);

        $this->assertDatabaseHas("maintenance_schedules", [
            "id" => $schedule->id,
        ]);

        $this->assertNotEquals($oldImagePath, $schedule->image_path);
        Storage::disk("public")->assertExists($newImagePath);
    }

    /** @test */
    public function it_can_remove_image_from_maintenance_schedule()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("etiket.jpg");
        $imagePath = $image->store("maintenance-schedules", "public");

        $schedule = MaintenanceSchedule::factory()->create([
            "asset_id" => $asset->id,
            "image_path" => $imagePath,
        ]);

        Storage::disk("public")->assertExists($imagePath);

        // Remove image
        if ($schedule->image_path) {
            Storage::disk("public")->delete($schedule->image_path);
        }

        $schedule->update(["image_path" => null]);

        $this->assertDatabaseHas("maintenance_schedules", [
            "id" => $schedule->id,
            "image_path" => null,
        ]);

        $this->assertNull($schedule->image_path);
    }

    /** @test */
    public function it_stores_image_in_correct_directory()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("etiket.jpg");

        $imagePath = $image->store("maintenance-schedules", "public");

        $this->assertStringContainsString("maintenance-schedules", $imagePath);

        Storage::disk("public")->assertExists($imagePath);
    }

    /** @test */
    public function it_handles_multiple_schedules_with_different_images()
    {
        $asset = Asset::factory()->create();

        $schedule1Image = UploadedFile::fake()->image("etiket1.jpg");
        $schedule1ImagePath = $schedule1Image->store(
            "maintenance-schedules",
            "public",
        );

        $schedule1 = MaintenanceSchedule::factory()->create([
            "asset_id" => $asset->id,
            "image_path" => $schedule1ImagePath,
            "frequency" => "bulanan",
        ]);

        $schedule2Image = UploadedFile::fake()->image("etiket2.jpg");
        $schedule2ImagePath = $schedule2Image->store(
            "maintenance-schedules",
            "public",
        );

        $schedule2 = MaintenanceSchedule::factory()->create([
            "asset_id" => $asset->id,
            "image_path" => $schedule2ImagePath,
            "frequency" => "triwulan",
        ]);

        Storage::disk("public")->assertExists($schedule1->image_path);
        Storage::disk("public")->assertExists($schedule2->image_path);

        $this->assertNotEquals($schedule1->image_path, $schedule2->image_path);
    }

    /** @test */
    public function it_can_create_schedule_with_all_frequencies()
    {
        $asset = Asset::factory()->create();
        $frequencies = [
            "harian",
            "mingguan",
            "bulanan",
            "triwulan",
            "semesteran",
            "tahunan",
        ];

        foreach ($frequencies as $frequency) {
            $image = UploadedFile::fake()->image("etiket-{$frequency}.jpg");
            $imagePath = $image->store("maintenance-schedules", "public");

            $schedule = MaintenanceSchedule::factory()->create([
                "asset_id" => $asset->id,
                "frequency" => $frequency,
                "image_path" => $imagePath,
            ]);

            $this->assertDatabaseHas("maintenance_schedules", [
                "id" => $schedule->id,
                "frequency" => $frequency,
            ]);

            Storage::disk("public")->assertExists($schedule->image_path);
        }
    }

    /** @test */
    public function it_preserves_image_when_updating_other_fields()
    {
        $asset = Asset::factory()->create();
        $image = UploadedFile::fake()->image("etiket.jpg");
        $imagePath = $image->store("maintenance-schedules", "public");

        $schedule = MaintenanceSchedule::factory()->create([
            "asset_id" => $asset->id,
            "image_path" => $imagePath,
            "status" => "terjadwal",
        ]);

        $originalImagePath = $schedule->image_path;

        // Update only status, image should remain
        $schedule->update(["status" => "selesai"]);

        $this->assertEquals($originalImagePath, $schedule->fresh()->image_path);
        Storage::disk("public")->assertExists($originalImagePath);
    }
}
