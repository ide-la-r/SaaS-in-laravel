<?php

namespace App\Livewire;

use App\Actions\CreateProject;
use App\Exceptions\PlanLimitExceededException;
use App\Http\Requests\StoreProjectRequest;
use Livewire\Component;

class CreateProjectForm extends Component
{
    public string $name = '';
    public string $description = '';

    public function save(): void
    {
        $request = new StoreProjectRequest();
        $request->merge($this->only(['name', 'description']));
        $request->setUserResolver(fn() => auth()->user());
        $validated = $request->validateResolved();

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
