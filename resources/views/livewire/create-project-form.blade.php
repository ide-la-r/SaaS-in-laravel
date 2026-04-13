<div class="max-w-lg">
    <x-card title="Crear proyecto">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del proyecto</label>
                <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm" placeholder="Mi proyecto">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción (opcional)</label>
                <textarea wire:model="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm" placeholder="Describe el proyecto..."></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('projects.index') }}" wire:navigate class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-sm text-white bg-brand-600 rounded-md hover:bg-brand-700">
                    <span wire:loading.remove wire:target="save">Crear proyecto</span>
                    <span wire:loading wire:target="save">Creando...</span>
                </button>
            </div>
        </form>
    </x-card>
</div>
