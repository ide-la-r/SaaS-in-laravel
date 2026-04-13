<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'stripe_price_id' => null,
                'price' => 0,
                'max_projects' => 3,
                'max_members' => 2,
                'features' => ['basic_boards'],
                'sort_order' => 1,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'stripe_price_id' => 'price_PREFIL_TODO',
                'price' => 1200,
                'max_projects' => 20,
                'max_members' => 10,
                'features' => ['basic_boards', 'integrations', 'priority_support'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'stripe_price_id' => 'price_PREFIL_TODO',
                'price' => 2900,
                'max_projects' => -1,
                'max_members' => -1,
                'features' => ['basic_boards', 'integrations', 'priority_support', 'advanced_analytics', 'custom_fields'],
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
