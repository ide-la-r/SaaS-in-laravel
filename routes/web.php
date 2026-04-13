<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Projects
    Route::view('projects', 'projects.index')->name('projects.index');
    Route::view('projects/create', 'projects.create')->name('projects.create');
    Route::get('projects/{project}/board/{board?}', function (\App\Models\Project $project, \App\Models\Board $board = null) {
        if (!$board) {
            $board = $project->boards()->first();
        }
        return view('projects.board', compact('project', 'board'));
    })->name('projects.board');

    // Team
    Route::view('team/members', 'team.members')->name('team.members');
    Route::view('team/settings', 'team.settings')->name('team.settings');

    // Billing
    Route::view('billing', 'billing')->name('billing');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
