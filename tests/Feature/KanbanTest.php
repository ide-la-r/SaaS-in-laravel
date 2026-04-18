<?php

namespace Tests\Feature;

use App\Actions\CreateTask;
use App\Actions\MoveTask;
use App\Models\Board;
use App\Models\Column;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanbanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task_in_column(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->for($user, 'owner')->create();
        $user->update(['current_team_id' => $team->id]);

        $project = Project::factory()->for($team)->create(['created_by' => $user->id]);
        $board = Board::factory()->for($project)->create();
        $column = Column::factory()->for($board)->create();

        $this->actingAs($user);

        $task = app(CreateTask::class)->execute($column, [
            'title' => 'My Task',
            'priority' => 'high',
        ]);

        $this->assertNotNull($task);
        $this->assertEquals('My Task', $task->title);
        $this->assertEquals($column->id, $task->column_id);
        $this->assertEquals(0, $task->position);
    }

    public function test_can_move_task_between_columns(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->for($user, 'owner')->create();
        $user->update(['current_team_id' => $team->id]);

        $project = Project::factory()->for($team)->create(['created_by' => $user->id]);
        $board = Board::factory()->for($project)->create();
        $column1 = Column::factory()->for($board)->create(['position' => 0, 'name' => 'Todo']);
        $column2 = Column::factory()->for($board)->create(['position' => 1, 'name' => 'Done']);

        $task = Task::factory()->for($column1)->create(['created_by' => $user->id, 'position' => 0]);

        $this->actingAs($user);

        // Move from column1 to column2
        $movedTask = app(MoveTask::class)->execute($task, $column2->id, 0);

        $this->assertEquals($column2->id, $movedTask->column_id);
        $this->assertEquals(0, $movedTask->position);

        // Verify original column is empty
        $this->assertEquals(0, $column1->tasks()->count());
        // Verify new column has the task
        $this->assertEquals(1, $column2->tasks()->count());
    }

    public function test_moving_task_reorders_positions(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->for($user, 'owner')->create();
        $user->update(['current_team_id' => $team->id]);

        $project = Project::factory()->for($team)->create(['created_by' => $user->id]);
        $board = Board::factory()->for($project)->create();
        $column = Column::factory()->for($board)->create();

        // Create 3 tasks
        $task1 = Task::factory()->for($column)->create(['position' => 0, 'created_by' => $user->id]);
        $task2 = Task::factory()->for($column)->create(['position' => 1, 'created_by' => $user->id]);
        $task3 = Task::factory()->for($column)->create(['position' => 2, 'created_by' => $user->id]);

        $this->actingAs($user);

        // Move task3 to position 0 (push others down)
        app(MoveTask::class)->execute($task3, $column->id, 0);

        $this->assertEquals(0, $task3->refresh()->position);
        $this->assertEquals(1, $task1->refresh()->position);  // Moved down
        $this->assertEquals(2, $task2->refresh()->position);  // Moved down
    }
}
