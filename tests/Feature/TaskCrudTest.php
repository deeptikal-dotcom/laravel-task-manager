<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_renders(): void
    {
        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Tasks');
    }

    public function test_task_can_be_created(): void
    {
        $this->post(route('tasks.store'), [
            'title'       => 'Ship the app',
            'description' => 'Final polish',
            'status'      => Task::STATUS_PENDING,
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['title' => 'Ship the app']);
    }

    public function test_title_is_required(): void
    {
        $this->from(route('tasks.create'))
            ->post(route('tasks.store'), ['status' => Task::STATUS_PENDING])
            ->assertRedirect(route('tasks.create'))
            ->assertSessionHasErrors('title');
    }

    public function test_status_must_be_valid(): void
    {
        $this->post(route('tasks.store'), [
            'title'  => 'Bad status',
            'status' => 'in_progress',
        ])->assertSessionHasErrors('status');
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::create([
            'title'  => 'Old',
            'status' => Task::STATUS_PENDING,
        ]);

        $this->put(route('tasks.update', $task), [
            'title'  => 'New',
            'status' => Task::STATUS_COMPLETED,
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'title'  => 'New',
            'status' => Task::STATUS_COMPLETED,
        ]);
    }

    public function test_status_toggle(): void
    {
        $task = Task::create([
            'title'  => 'Toggle me',
            'status' => Task::STATUS_PENDING,
        ]);

        $this->post(route('tasks.toggle', $task))->assertRedirect();

        $this->assertSame(Task::STATUS_COMPLETED, $task->fresh()->status);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::create([
            'title'  => 'Delete me',
            'status' => Task::STATUS_PENDING,
        ]);

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
