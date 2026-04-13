<?php

namespace App\Livewire;

use App\Actions\CreateTask;
use App\Actions\MoveTask;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;

class KanbanBoard extends Component
{
    public Board $board;

    public ?int $editingTaskId = null;
    public ?int $addingToColumnId = null;
    public string $newTaskTitle = '';

    public function mount(Board $board): void
    {
        $this->board = $board;
    }

    public function startAddTask(int $columnId): void
    {
        $this->addingToColumnId = $columnId;
        $this->newTaskTitle = '';
    }

    public function cancelAddTask(): void
    {
        $this->addingToColumnId = null;
        $this->newTaskTitle = '';
    }

    public function addTask(int $columnId): void
    {
        $this->validate(['newTaskTitle' => 'required|min:1|max:255']);

        $column = Column::findOrFail($columnId);
        app(CreateTask::class)->execute($column, [
            'title' => $this->newTaskTitle,
        ]);

        $this->addingToColumnId = null;
        $this->newTaskTitle = '';
    }

    public function moveTask(int $taskId, int $columnId, int $position): void
    {
        $task = Task::findOrFail($taskId);
        app(MoveTask::class)->execute($task, $columnId, $position);
    }

    public function openTask(int $taskId): void
    {
        $this->editingTaskId = $taskId;
        $this->dispatch('open-task-detail', taskId: $taskId);
    }

    #[On('task-updated')]
    public function refreshBoard(): void
    {
        $this->board->refresh();
    }

    #[On('close-task-detail')]
    public function closeTask(): void
    {
        $this->editingTaskId = null;
    }

    public function render()
    {
        $columns = $this->board->columns()
            ->with(['tasks' => fn ($q) => $q->orderBy('position')->with('assignee')])
            ->orderBy('position')
            ->get();

        return view('livewire.kanban-board', [
            'columns' => $columns,
        ]);
    }
}
