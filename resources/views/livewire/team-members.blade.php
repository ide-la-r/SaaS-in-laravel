<div class="space-y-6">
    <!-- Invite form -->
    <x-card title="Invitar miembro">
        <form wire:submit="invite" class="flex items-end space-x-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" wire:model="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm" placeholder="usuario@email.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select wire:model="role" class="rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                    <option value="member">Miembro</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 text-sm text-white bg-brand-600 rounded-md hover:bg-brand-700">Invitar</button>
        </form>
        @if($memberLimit > 0)
            <p class="text-xs text-gray-400 mt-2">{{ $members->count() }} / {{ $memberLimit == -1 ? 'ilimitados' : $memberLimit }} miembros</p>
        @endif
    </x-card>

    <!-- Members list -->
    <x-card title="Miembros del equipo">
        <div class="divide-y divide-gray-200 -mx-6 -mb-6">
            @foreach($members as $member)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full bg-brand-100 flex items-center justify-center text-sm font-medium text-brand-700">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                            <p class="text-sm text-gray-500">{{ $member->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        @if($team->owner_id === $member->id)
                            <x-badge color="indigo">Propietario</x-badge>
                        @else
                            <select wire:change="changeRole({{ $member->id }}, $event.target.value)"
                                    class="rounded-md border-gray-300 shadow-sm text-xs focus:border-brand-500 focus:ring-brand-500">
                                <option value="member" @selected($member->pivot->role === 'member')>Miembro</option>
                                <option value="admin" @selected($member->pivot->role === 'admin')>Admin</option>
                            </select>
                            <button wire:click="removeMember({{ $member->id }})"
                                    wire:confirm="¿Seguro que quieres eliminar a {{ $member->name }}?"
                                    class="text-red-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
</div>
