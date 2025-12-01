<?php

namespace Database\Factories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetCategoryFactory extends Factory
{
    protected $model = AssetCategory::class;

    public function definition(): array
    {
        return [
            "name" => fake()
                ->unique()
                ->randomElement([
                    "Komputer & Laptop",
                    "Mesin Produksi",
                    "Furniture Kantor",
                    "Kendaraan",
                    "Elektronik",
                    "Peralatan Lab",
                ]),
            "description" => fake()->optional()->sentence(),
        ];
    }
}
