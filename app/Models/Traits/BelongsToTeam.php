<?php

namespace App\Models\Traits;

use App\Models\Scopes\TeamScope;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(new TeamScope);

        static::creating(function ($model) {
            if (auth()->check() && !isset($model->team_id)) {
                $model->team_id = auth()->user()->current_team_id;
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
