<div>
    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Buscar proyectos..."
                   class="rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm w-full sm:w-64">
            <select wire:model.live="statusFilter" class="rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                <option value="">Todos</option>
                <option value="active">Activos</option>
                <option value="archived">Archivados</option>
            </select>
        </div>
        <a href="{{ route('projects.create') }}" wire:navigate
           class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-md hover:bg-brand-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo proyecto
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tableros</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creado por</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($projects as $project)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $project->name }}</div>
                            @if($project->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($project->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <x-badge :color="$project->status === 'active' ? 'green' : 'gray'">
                                {{ $project->status === 'active' ? 'Activo' : 'Archivado' }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $project->boards_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $project->creator->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $project->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('projects.board', $project) }}" wire:navigate class="text-brand-600 hover:text-brand-800 text-sm font-medium">
                                Abrir tablero
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No hay proyectos. <a href="{{ route('projects.create') }}" class="text-brand-600 hover:underline">Crea tu primero</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
