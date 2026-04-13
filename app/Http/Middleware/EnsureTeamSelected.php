<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->current_team_id) {
            $team = auth()->user()->teams()->first();

            if ($team) {
                auth()->user()->update(['current_team_id' => $team->id]);
            }
        }

        return $next($request);
    }
}
