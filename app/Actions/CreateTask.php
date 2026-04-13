<?php

namespace App\Actions;

use App\Models\ActivityLog;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CreateTask
{
    public function execute(Column $column, array $data): Task
    {
        $maxPosition = $column->tasks()->max('position') ?? -1;

        $task = Task::create([
            'column_id' => $column->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'priority' => $data['priority'] ?? 'medium',
            'position' => $maxPosition + 1,
            'assigned_to' => $data['assigned_to'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'created_by' => Auth::id(),
        ]);

        $team = $column->board->project->team;

        ActivityLog::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
            'subject_type' => Task::class,
            'subject_id' => $task->id,
            'action' => 'created',
            'properties' => ['title' => $task->title, 'column' => $column->name],
        ]);

        return $task;
    }
}
