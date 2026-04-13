<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-500">Proyectos</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalProjects }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-500">Total tareas</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalTasks }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-500">Pendientes</div>
            <div class="mt-1 text-3xl font-bold text-amber-600">{{ $pendingTasks }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-500">Completadas esta semana</div>
            <div class="mt-1 text-3xl font-bold text-green-600">{{ $completedThisWeek }}</div>
        </div>
    </div>

    <!-- Projects + Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Projects list (2/3) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Proyectos activos</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($projects as $project)
                        <div class="p-4 hover:bg-gray-50 flex justify-between items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $project->name }}</div>
                                @if($project->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($project->description, 80) }}</div>
                                @endif
                            </div>
                            <div class="text-sm text-gray-400">
                                {{ $project->boards_count }} {{ Str::plural('tablero', $project->boards_count) }}
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            No hay proyectos aún. ¡Crea tu primero!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Activity feed (1/3) -->
        <div>
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Actividad reciente</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($activities as $activity)
                        <div class="p-4">
                            <div class="text-sm">
                                <span class="font-medium text-gray-900">{{ $activity->user->name }}</span>
                                <span class="text-gray-500">{{ $activity->action }}</span>
                                @if($activity->properties)
                                    <span class="text-gray-700">{{ $activity->properties['name'] ?? $activity->properties['title'] ?? '' }}</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            Sin actividad reciente.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
