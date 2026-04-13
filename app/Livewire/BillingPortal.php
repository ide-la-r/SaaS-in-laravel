<?php

namespace App\Livewire;

use App\Actions\UpgradePlan;
use App\Models\Plan;
use Livewire\Component;

class BillingPortal extends Component
{
    public function changePlan(int $planId): void
    {
        $team = auth()->user()->currentTeam;
        $newPlan = Plan::findOrFail($planId);

        app(UpgradePlan::class)->execute($team, $newPlan);

        session()->flash('success', 'Plan actualizado a ' . $newPlan->name);
    }

    public function render()
    {
        $team = auth()->user()->currentTeam;
        $currentPlan = $team?->plan;
        $plans = Plan::orderBy('sort_order')->get();

        return view('livewire.billing-portal', [
            'team' => $team,
            'currentPlan' => $currentPlan,
            'plans' => $plans,
        ]);
    }
}
