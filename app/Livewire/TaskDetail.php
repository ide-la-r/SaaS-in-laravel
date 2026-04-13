<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class TaskDetail extends Component
{
    public Task $task;

    public string $title = '';
    public string $description = '';
    public string $priority = 'medium';
    public ?int $assignedTo = null;
    public ?string $dueDate = null;

    public function mount(int $taskId): void
    {
        $this->task = Task::findOrFail($taskId);
        $this->title = $this->task->title;
        $this->description = $this->task->description ?? '';
        $this->priority = $this->task->priority;
        $this->assignedTo = $this->task->assigned_to;
        $this->dueDate = $this->task->due_date?->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|min:1|max:255',
            'priority' => 'in:low,medium,high,urgent',
        ]);

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description ?: null,
            'priority' => $this->priority,
            'assigned_to' => $this->assignedTo,
            'due_date' => $this->dueDate,
        ]);

        $this->dispatch('task-updated');
    }

    public function deleteTask(): void
    {
        $this->task->delete();
        $this->dispatch('task-updated');
        $this->dispatch('close-task-detail');
    }

    public function close(): void
    {
        $this->dispatch('close-task-detail');
    }

    public function render()
    {
        $team = auth()->user()->currentTeam;
        $members = $team ? $team->members : collect();

        return view('livewire.task-detail', [
            'members' => $members,
        ]);
    }
}
