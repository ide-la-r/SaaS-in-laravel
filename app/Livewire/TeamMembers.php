<?php

namespace App\Livewire;

use App\Actions\InviteMember;
use App\Exceptions\PlanLimitExceededException;
use App\Http\Requests\InviteMemberRequest;
use App\Models\Team;
use Livewire\Component;

class TeamMembers extends Component
{
    public string $email = '';
    public string $role = 'member';

    public function invite(): void
    {
        $request = new InviteMemberRequest();
        $request->merge($this->only(['email', 'role']));
        $request->setUserResolver(fn() => auth()->user());
        $validated = $request->validateResolved();

        $team = auth()->user()->currentTeam;

        try {
            app(InviteMember::class)->execute($team, $this->email, $this->role);
            $this->email = '';
            session()->flash('success', 'Miembro invitado correctamente.');
        } catch (PlanLimitExceededException $e) {
            session()->flash('error', $e->getMessage());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            session()->flash('error', 'No se encontró un usuario con ese email.');
        }
    }

    public function changeRole(int $userId, string $newRole): void
    {
        $team = auth()->user()->currentTeam;
        $team->members()->updateExistingPivot($userId, ['role' => $newRole]);
    }

    public function removeMember(int $userId): void
    {
        $team = auth()->user()->currentTeam;

        if ($team->owner_id === $userId) {
            session()->flash('error', 'No puedes eliminar al propietario del equipo.');
            return;
        }

        $team->members()->detach($userId);
    }

    public function render()
    {
        $team = auth()->user()->currentTeam;
        $members = $team ? $team->members()->withPivot('role')->get() : collect();
        $plan = $team?->plan;
        $memberLimit = $plan?->max_members ?? 0;

        return view('livewire.team-members', [
            'members' => $members,
            'team' => $team,
            'memberLimit' => $memberLimit,
        ]);
    }
}
