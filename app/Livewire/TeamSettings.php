<?php

namespace App\Livewire;

use Livewire\Component;

class TeamSettings extends Component
{
    public string $teamName = '';

    public function mount(): void
    {
        $team = auth()->user()->currentTeam;
        $this->teamName = $team?->name ?? '';
    }

    public function save(): void
    {
        $this->validate(['teamName' => 'required|min:2|max:255']);

        $team = auth()->user()->currentTeam;
        $team->update(['name' => $this->teamName]);
        session()->flash('success', 'Nombre del equipo actualizado.');
    }

    public function render()
    {
        $team = auth()->user()->currentTeam;
        $plan = $team?->plan;
        $projectCount = $team ? $team->projects()->count() : 0;
        $memberCount = $team ? $team->members()->count() : 0;

        return view('livewire.team-settings', [
            'team' => $team,
            'plan' => $plan,
            'projectCount' => $projectCount,
            'memberCount' => $memberCount,
        ]);
    }
}
