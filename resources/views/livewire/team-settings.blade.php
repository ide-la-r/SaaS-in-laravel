<div class="space-y-6 max-w-lg">
    <!-- Team name -->
    <x-card title="Nombre del equipo">
        <form wire:submit="save" class="flex items-end space-x-3">
            <div class="flex-1">
                <input type="text" wire:model="teamName" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 text-sm text-white bg-brand-600 rounded-md hover:bg-brand-700">Guardar</button>
        </form>
    </x-card>

    <!-- Plan usage -->
    @if($plan)
    <x-card title="Plan actual: {{ $plan->name }}">
        <div class="space-y-3">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Proyectos</span>
                    <span class="font-medium">{{ $projectCount }} / {{ $plan->max_projects == -1 ? 'ilimitados' : $plan->max_projects }}</span>
                </div>
                @if($plan->max_projects > 0)
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-brand-600 h-2 rounded-full" style="width: {{ min(100, ($projectCount / $plan->max_projects) * 100) }}%"></div>
                    </div>
                @endif
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Miembros</span>
                    <span class="font-medium">{{ $memberCount }} / {{ $plan->max_members == -1 ? 'ilimitados' : $plan->max_members }}</span>
                </div>
                @if($plan->max_members > 0)
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-brand-600 h-2 rounded-full" style="width: {{ min(100, ($memberCount / $plan->max_members) * 100) }}%"></div>
                    </div>
                @endif
            </div>
            <a href="{{ route('billing') }}" wire:navigate class="mt-2 inline-block text-sm text-brand-600 hover:text-brand-800 font-medium">Cambiar plan &rarr;</a>
        </div>
    </x-card>
    @endif
</div>
