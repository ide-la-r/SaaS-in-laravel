<div>
    <div class="flex space-x-4 overflow-x-auto pb-4" x-data="kanban()">
        @foreach($columns as $column)
            <div class="flex-shrink-0 w-80">
                <!-- Column header -->
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $column->color }}"></div>
                        <h3 class="font-semibold text-gray-700 text-sm">{{ $column->name }}</h3>
                        <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-2 py-0.5">{{ $column->tasks->count() }}</span>
                    </div>
                    <button wire:click="startAddTask({{ $column->id }})" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>

                <!-- Tasks container -->
                <div class="space-y-2 min-h-[100px] rounded-lg bg-gray-100 p-2"
                     x-ref="column{{ $column->id }}"
                     data-column-id="{{ $column->id }}"
                     x-init="initSortable($refs['column{{ $column->id }}'])">

                    @foreach($column->tasks as $task)
                        <div class="bg-white rounded-lg shadow-sm p-3 cursor-pointer hover:shadow-md transition-shadow border border-gray-200"
                             wire:click="openTask({{ $task->id }})"
                             data-task-id="{{ $task->id }}">
                            <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <x-badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'yellow', 'medium' => 'blue', default => 'gray' }">
                                    {{ $task->priority }}
                                </x-badge>
                                @if($task->assignee)
                                    <div class="h-6 w-6 rounded-full bg-brand-100 flex items-center justify-center text-xs font-medium text-brand-700" title="{{ $task->assignee->name }}">
                                        {{ substr($task->assignee->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            @if($task->due_date)
                                <p class="text-xs text-gray-400 mt-1">{{ $task->due_date->format('d M') }}</p>
                            @endif
                        </div>
                    @endforeach

                    <!-- Inline add task -->
                    @if($addingToColumnId === $column->id)
                        <div class="bg-white rounded-lg shadow-sm p-3 border-2 border-brand-300">
                            <input type="text"
                                   wire:model="newTaskTitle"
                                   wire:keydown.enter="addTask({{ $column->id }})"
                                   wire:keydown.escape="cancelAddTask"
                                   placeholder="Nombre de la tarea..."
                                   class="w-full text-sm border-0 p-0 focus:ring-0 placeholder-gray-400"
                                   autofocus>
                            <div class="flex justify-end space-x-2 mt-2">
                                <button wire:click="cancelAddTask" class="text-xs text-gray-500 hover:text-gray-700">Cancelar</button>
                                <button wire:click="addTask({{ $column->id }})" class="text-xs bg-brand-600 text-white px-3 py-1 rounded hover:bg-brand-700">Crear</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Task detail modal -->
    @if($editingTaskId)
        <livewire:task-detail :task-id="$editingTaskId" :key="'task-'.$editingTaskId" />
    @endif
</div>

@script
<script>
    Alpine.data('kanban', () => ({
        initSortable(el) {
            if (typeof Sortable === 'undefined') return;
            new Sortable(el, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'opacity-50',
                filter: 'input, button',
                onEnd: (evt) => {
                    const taskId = parseInt(evt.item.dataset.taskId);
                    const columnId = parseInt(evt.to.dataset.columnId);
                    const position = evt.newIndex;
                    $wire.moveTask(taskId, columnId, position);
                }
            });
        }
    }));
</script>
@endscript
