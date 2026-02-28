<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::role('teacher')->doesntHave('notificationSettings')
            ->get()
            ->each(fn($user) => NotificationSetting::factory()->teacher()->create(['user_id' => $user->id]));

        User::role('student')->doesntHave('notificationSettings')
            ->get()
            ->each(fn($user) => NotificationSetting::factory()->student()->create(['user_id' => $user->id]));
    }
}
