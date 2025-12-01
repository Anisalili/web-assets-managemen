<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            "asset_code" =>
                "AST-" . strtoupper(fake()->unique()->bothify("???-###")),
            "name" =>
                fake()->words(3, true) .
                " " .
                fake()->randomElement([
                    "Laptop",
                    "Printer",
                    "AC",
                    "Meja",
                    "Kursi",
                ]),
            "category_id" => AssetCategory::factory(),
            "room_id" => fake()
                ->optional(0.8)
                ->randomElement([Room::factory()]),
            "status" => fake()->randomElement([
                "aktif",
                "non-aktif",
                "dalam_perbaikan",
                "rusak",
            ]),
            "owner" => fake()
                ->optional(0.7)
                ->randomElement([
                    "Bagian IT",
                    "Bagian Produksi",
                    "Bagian Finance",
                    "Bagian HRD",
                ]),
            "private_owner" => fake()->optional(0.3)->name(),
            "purchase_date" => fake()
                ->optional(0.8)
                ->dateTimeBetween("-5 years", "now"),
            "value" => fake()->optional(0.7)->numberBetween(1000000, 50000000),
            "notes" => fake()->optional(0.4)->sentence(),
        ];
    }

    public function withPrivateOwner(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "private_owner" => fake()->name(),
            ],
        );
    }

    public function withoutPrivateOwner(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "private_owner" => null,
            ],
        );
    }

    public function withValue(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "value" => fake()->numberBetween(1000000, 50000000),
            ],
        );
    }

    public function withoutValue(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "value" => null,
            ],
        );
    }
}
