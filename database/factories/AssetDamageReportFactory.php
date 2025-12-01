<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetDamageReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetDamageReportFactory extends Factory
{
    protected $model = AssetDamageReport::class;

    public function definition(): array
    {
        $reportDate = fake()->dateTimeBetween("-6 months", "now");
        $status = fake()->randomElement([
            "dilaporkan",
            "dalam_proses",
            "selesai",
        ]);

        return [
            "asset_id" => Asset::factory(),
            "reported_by" => User::factory(),
            "assigned_to" => fake()
                ->optional(0.7)
                ->randomElement([User::factory()]),
            "report_date" => $reportDate,
            "severity" => fake()->randomElement(["ringan", "sedang", "berat"]),
            "damage_type" => fake()->randomElement([
                "mechanical",
                "electrical",
                "structural",
                "software",
                "hardware",
            ]),
            "priority" => fake()->randomElement([
                "low",
                "medium",
                "high",
                "critical",
            ]),
            "description" => fake()->paragraph(),
            "impact_on_operations" => fake()->optional(0.6)->sentence(),
            "image_path" => null,
            "estimated_repair_cost" => fake()
                ->optional(0.6)
                ->numberBetween(500000, 10000000),
            "status" => $status,
            "resolved_date" =>
                $status === "selesai"
                    ? fake()->dateTimeBetween($reportDate, "now")
                    : null,
            "resolved_by" => $status === "selesai" ? User::factory() : null,
        ];
    }

    public function withImage(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "image_path" => "damage-reports/" . fake()->uuid() . ".jpg",
            ],
        );
    }

    public function withoutEstimatedCost(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "estimated_repair_cost" => null,
            ],
        );
    }

    public function dilaporkan(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "status" => "dilaporkan",
                "resolved_date" => null,
                "resolved_by" => null,
            ],
        );
    }

    public function dalamProses(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "status" => "dalam_proses",
                "assigned_to" => User::factory(),
                "resolved_date" => null,
                "resolved_by" => null,
            ],
        );
    }

    public function selesai(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "status" => "selesai",
                "assigned_to" => User::factory(),
                "resolved_date" => fake()->dateTimeBetween(
                    $attributes["report_date"] ?? "-1 month",
                    "now",
                ),
                "resolved_by" => User::factory(),
            ],
        );
    }
}
