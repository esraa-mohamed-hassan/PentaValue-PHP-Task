<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert records into accounts table
        $account = Account::create([
            'name' => 'Account 1',
        ]);

        // Insert records into projects table
        $project = $account->projects()->create([
            'name' => 'Project 1',
            'price' => 100.00,
        ]);

        // Insert records into jobs table
        $job1 = $project->jobs()->create([
            'name' => 'Job 1',
            'amount' => 50.00,
        ]);

        // Insert records into tasks table
        $project->tasks()->create([
            'name' => 'Task 1',
        ]);

        $project->tasks()->create([
            'name' => 'Task 2',
        ]);

        $job2 = $project->jobs()->create([
            'name' => 'Job 2',
            'amount' => 60.00,
        ]);

        $project->tasks()->create([
            'name' => 'Task 3',
        ]);


        // =====================================================

        $account2 = Account::create([
            'name' => 'Account 2',
        ]);

        $project2 = $account2->projects()->create([
            'name' => 'Project 2',
            'price' => 80.00,
        ]);

        $job3 = $project2->jobs()->create([
            'name' => 'Job 3',
            'amount' => 60.00,
        ]);

        $project2->tasks()->create([
            'name' => 'Task 4',
        ]);

        $project2->tasks()->create([
            'name' => 'Task 5',
        ]);

        $project3 = $account2->projects()->create([
            'name' => 'Project 3',
            'price' => 60.00,
        ]);

        $job4 = $project3->jobs()->create([
            'name' => 'Job 4',
            'amount' => 60.00,
        ]);

        $project3->tasks()->create([
            'name' => 'Task 6',
        ]);
    }
}
