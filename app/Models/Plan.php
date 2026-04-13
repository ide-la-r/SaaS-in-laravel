<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'stripe_price_id',
        'price',
        'features',
        'max_projects',
        'max_members',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'integer',
        ];
    }
}
