<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $team = Auth::user()->currentTeam;

        $totalProjects = $team ? Project::where('team_id', $team->id)->count() : 0;

        $totalTasks = 0;
        $completedThisWeek = 0;
        $pendingTasks = 0;

        if ($team) {
            $projectIds = Project::where('team_id', $team->id)->pluck('id');

            $boardIds = \App\Models\Board::whereIn('project_id', $projectIds)->pluck('id');
            $columnIds = \App\Models\Column::whereIn('board_id', $boardIds)->pluck('id');

            $totalTasks = Task::whereIn('column_id', $columnIds)->count();

            // "Hecho" columns
            $doneColumnIds = \App\Models\Column::whereIn('board_id', $boardIds)
                ->where('name', 'Hecho')
                ->pluck('id');

            $completedThisWeek = Task::whereIn('column_id', $doneColumnIds)
                ->where('updated_at', '>=', now()->startOfWeek())
                ->count();

            $pendingTasks = $totalTasks - Task::whereIn('column_id', $doneColumnIds)->count();
        }

        $projects = $team
            ? Project::where('team_id', $team->id)
                ->where('status', 'active')
                ->withCount(['boards'])
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $activities = $team
            ? ActivityLog::where('team_id', $team->id)
                ->with('user')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        return view('livewire.dashboard', [
            'totalProjects' => $totalProjects,
            'totalTasks' => $totalTasks,
            'completedThisWeek' => $completedThisWeek,
            'pendingTasks' => $pendingTasks,
            'projects' => $projects,
            'activities' => $activities,
            'team' => $team,
        ]);
    }
}
