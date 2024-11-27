<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Task::create([
            'title' => 'Task 1',
            'description' => 'Description for Task 1',
            'due_date' => Carbon::now()->addDays(1),
            'completed' => true,
        ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Description for Task 2',
            'due_date' => Carbon::now()->addDays(1),
            'completed' => true,
        ]);

        Task::create([
            'title' => 'Task 3',
            'description' => 'Description for Task 3',
            'due_date' => Carbon::now()->addDays(1),
            'completed' => false,
        ]);
        Task::create([
            'title' => 'Task 1',
            'description' => 'Description for Task 1',
            'due_date' => Carbon::now()->addDays(2),
            'completed' => true,
        ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Description for Task 2',
            'due_date' => Carbon::now()->addDays(2),
            'completed' => true,
        ]);

        Task::create([
            'title' => 'Task 3',
            'description' => 'Description for Task 3',
            'due_date' => Carbon::now()->addDays(2),
            'completed' => false,
        ]);
    }
}
