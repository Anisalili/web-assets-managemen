<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition(): array
    {
        return [
            "building_code" => "BLD-" . fake()->unique()->numerify("###"),
            "name" =>
                "Gedung " .
                fake()->randomElement(["A", "B", "C", "Utama", "Produksi"]),
            "description" => fake()->optional()->sentence(),
        ];
    }
}
