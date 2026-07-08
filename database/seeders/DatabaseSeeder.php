<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Task::query()->create([
            'title'       => 'Read the youbloom brief',
            'description' => 'Review the task manager test PDF and plan the build.',
            'status'      => Task::STATUS_COMPLETED,
        ]);

        Task::query()->create([
            'title'       => 'Build the Task Manager',
            'description' => 'Implement CRUD, validation, and Bootstrap 4 UI.',
            'status'      => Task::STATUS_PENDING,
        ]);

        Task::query()->create([
            'title'       => 'Push to GitHub',
            'description' => 'Commit frequently with meaningful messages.',
            'status'      => Task::STATUS_PENDING,
        ]);
    }
}
