<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory(10)->create();

        // Create notifications for all users
        $allUsers = User::all();

        foreach ($allUsers as $user) {
            // Create notifications for each user based on their type
            Notification::factory(3)->marketing()->create(['user_id' => $user->id]);
            Notification::factory(2)->invoices()->create(['user_id' => $user->id]);
            Notification::factory(1)->system()->create(['user_id' => $user->id]);

            // Create unread notifications for users
            Notification::factory(2)->unread()->create(['user_id' => $user->id]);
        }
    }
}
