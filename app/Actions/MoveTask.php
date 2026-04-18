<?php

namespace App\Actions;

use App\Models\ActivityLog;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MoveTask
{
    public function execute(Task $task, int $columnId, int $position): Task
    {
        Gate::authorize('update', $task);
        return DB::transaction(function () use ($task, $columnId, $position) {
            $oldColumn = $task->column;
            $newColumn = Column::findOrFail($columnId);

            // Reorder tasks in the old column (close the gap)
            Task::where('column_id', $oldColumn->id)
                ->where('position', '>', $task->position)
                ->decrement('position');

            // Make space in the new column
            Task::where('column_id', $newColumn->id)
                ->where('position', '>=', $position)
                ->increment('position');

            $task->update([
                'column_id' => $newColumn->id,
                'position' => $position,
            ]);

            $team = $newColumn->board->project->team;

            ActivityLog::create([
                'team_id' => $team->id,
                'user_id' => Auth::id(),
                'subject_type' => Task::class,
                'subject_id' => $task->id,
                'action' => 'moved',
                'properties' => [
                    'from' => $oldColumn->name,
                    'to' => $newColumn->name,
                ],
            ]);

            return $task->fresh();
        });
    }
}
