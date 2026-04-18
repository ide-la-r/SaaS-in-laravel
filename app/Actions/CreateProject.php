<?php

namespace App\Actions;

use App\Models\ActivityLog;
use App\Models\Board;
use App\Models\Column;
use App\Models\Project;
use App\Models\Team;
use App\Services\PlanLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreateProject
{
    public function execute(Team $team, array $data): Project
    {
        Gate::authorize('create', Project::class);
        PlanLimiter::check($team, 'max_projects');

        return DB::transaction(function () use ($team, $data) {
            $project = Project::create([
                'team_id' => $team->id,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => 'active',
                'created_by' => Auth::id(),
            ]);

            // Board por defecto
            $board = Board::create([
                'project_id' => $project->id,
                'name' => 'Principal',
                'position' => 0,
            ]);

            // Columnas por defecto estilo Kanban
            $defaults = [
                ['name' => 'Por hacer', 'color' => '#6366f1', 'position' => 0],
                ['name' => 'En progreso', 'color' => '#f59e0b', 'position' => 1],
                ['name' => 'Hecho', 'color' => '#10b981', 'position' => 2],
            ];

            foreach ($defaults as $col) {
                Column::create(array_merge($col, ['board_id' => $board->id]));
            }

            ActivityLog::create([
                'team_id' => $team->id,
                'user_id' => Auth::id(),
                'subject_type' => Project::class,
                'subject_id' => $project->id,
                'action' => 'created',
                'properties' => ['name' => $project->name],
            ]);

            return $project;
        });
    }
}
