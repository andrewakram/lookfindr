<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'done']),
            'project_id' => Project::factory(),  // create a project if not provided
            'user_id' => null,                   // or User::factory() if you want to assign a user
            'due_date' => $this->faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d H:i:s'),
        ];
    }
}
