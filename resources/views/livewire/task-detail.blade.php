<div class="fixed inset-0 z-50 overflow-y-auto" x-data x-on:keydown.escape.window="$wire.close()">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="close"></div>

        <div class="relative w-full max-w-lg transform rounded-lg bg-white shadow-xl transition-all">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Detalle de tarea</h3>
                <button wire:click="close" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" wire:model.blur="title" wire:change="save" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea wire:model.blur="description" wire:change="save" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm" placeholder="Añade una descripción..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                        <select wire:model.live="priority" wire:change="save" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                            <option value="low">Baja</option>
                            <option value="medium">Media</option>
                            <option value="high">Alta</option>
                            <option value="urgent">Urgente</option>
                        </select>
                    </div>

                    <!-- Assigned to -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asignado a</label>
                        <select wire:model.live="assignedTo" wire:change="save" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                            <option value="">Sin asignar</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Due date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha límite</label>
                    <input type="date" wire:model.live="dueDate" wire:change="save" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-between">
                <button wire:click="deleteTask" wire:confirm="¿Seguro que quieres eliminar esta tarea?"
                        class="text-sm text-red-600 hover:text-red-800">
                    Eliminar tarea
                </button>
                <button wire:click="close" class="text-sm bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
