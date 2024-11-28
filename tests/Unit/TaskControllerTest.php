<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_get_all_tasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /** @test */
    public function it_can_store_a_new_task()
    {
        $taskData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => '25-12-2023',
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'title' => $taskData['title'],
            'description' => $taskData['description'],
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing_task()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'due_date']);
    }

    /** @test */
    public function it_can_get_a_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
        ]);
    }

    /** @test */
    public function it_returns_404_if_task_not_found()
    {
        $response = $this->getJson('/api/tasks/99999');

        $response->assertStatus(404);
        $response->assertJson(['errors' => 'Task not found']);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'due_date' => '25-12-2023',
            'completed' => true,
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'due_date' => '2023-12-25',
            'completed' => true,
        ]);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
