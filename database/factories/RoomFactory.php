<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            "room_code" => "RM-" . fake()->unique()->numerify("###"),
            "building_id" => Building::factory(),
            "name" => fake()->randomElement([
                "Ruang Meeting",
                "Ruang Server",
                "Ruang Produksi",
                "Ruang QC",
                "Kantor",
            ]),
            "description" => fake()->optional()->sentence(),
        ];
    }
}
