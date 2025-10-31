<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceLog>
 */
class MaintenanceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $datePerformed = fake()->dateTimeBetween('-6 months', 'now');

        return [
            'schedule_id' => fake()->optional(0.6)->randomElement(
                MaintenanceSchedule::pluck('id')->toArray()
            ),
            'asset_id' => Asset::inRandomOrder()->first()?->id ?? Asset::factory(),
            'performed_by' => fake()->name(),
            'date_performed' => $datePerformed,
            'result' => fake()->optional(0.9)->paragraph(3),
            'next_recommendation_date' => fake()->optional(0.5)->dateTimeBetween(
                $datePerformed,
                '+6 months'
            ),
        ];
    }

    /**
     * Indicate that the log has a related schedule.
     */
    public function withSchedule(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_id' => MaintenanceSchedule::inRandomOrder()->first()?->id ?? MaintenanceSchedule::factory(),
        ]);
    }

    /**
     * Indicate that the log is standalone (no schedule).
     */
    public function standalone(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_id' => null,
        ]);
    }
}
