<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['marketing', 'invoices', 'system']),
            'short_text' => fake()->sentence(8),
            'expiration' => fake()->dateTimeBetween('+1 day', '+30 days'),
            'is_read' => fake()->boolean(30)
        ];
    }

    /**
     * Indicate that the notification is for marketing.
     */
    public function marketing(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'marketing',
            'short_text' => 'Special offer: ' . fake()->sentence(5),
        ]);
    }

    /**
     * Indicate that the notification is for invoices.
     */
    public function invoices(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'invoices',
            'short_text' => 'Invoice #' . fake()->numberBetween(1000, 9999) . ' is ready',
        ]);
    }

    /**
     * Indicate that the notification is for system.
     */
    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'system',
            'short_text' => 'System maintenance: ' . fake()->sentence(4),
        ]);
    }

    /**
     * Indicate that the notification is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
        ]);
    }
}
