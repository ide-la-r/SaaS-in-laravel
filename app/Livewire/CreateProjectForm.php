<?php

namespace App\Livewire;

use App\Actions\CreateProject;
use App\Exceptions\PlanLimitExceededException;
use Livewire\Component;

class CreateProjectForm extends Component
{
    public string $name = '';
    public string $description = '';

    public function save(): void
    {
        $this->validate([
            'name' => 'required|min:2|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $team = auth()->user()->currentTeam;

        try {
            $project = app(CreateProject::class)->execute($team, [
                'name' => $this->name,
                'description' => $this->description,
            ]);

            $this->redirect(route('projects.board', $project), navigate: true);
        } catch (PlanLimitExceededException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-project-form');
    }
}
