<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceSchedule>
 */
class MaintenanceScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $frequencies = ['harian', 'mingguan', 'bulanan', 'triwulan', 'semesteran', 'tahunan'];
        $statuses = ['terjadwal', 'selesai', 'dibatalkan'];

        return [
            'asset_id' => Asset::inRandomOrder()->first()?->id ?? Asset::factory(),
            'scheduled_date' => fake()->dateTimeBetween('-2 months', '+3 months'),
            'frequency' => fake()->randomElement($frequencies),
            'description' => fake()->optional(0.7)->sentence(10),
            'assigned_to' => null, // Kosongkan, akan di-assign manual
            'status' => fake()->randomElement($statuses),
        ];
    }

    /**
     * Indicate that the schedule is pending (terjadwal).
     */
    public function terjadwal(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'terjadwal',
            'scheduled_date' => fake()->dateTimeBetween('now', '+3 months'),
        ]);
    }

    /**
     * Indicate that the schedule is completed (selesai).
     */
    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
            'scheduled_date' => fake()->dateTimeBetween('-2 months', 'now'),
        ]);
    }

    /**
     * Indicate that the schedule is cancelled (dibatalkan).
     */
    public function dibatalkan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dibatalkan',
        ]);
    }
}
