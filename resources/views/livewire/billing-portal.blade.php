<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <div class="bg-white rounded-lg shadow {{ $currentPlan?->id === $plan->id ? 'ring-2 ring-brand-500' : '' }}">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $plan->name }}</h3>
                    <div class="mt-2">
                        <span class="text-3xl font-bold text-gray-900">{{ $plan->price == 0 ? 'Gratis' : '$' . number_format($plan->price / 100, 0) }}</span>
                        @if($plan->price > 0)
                            <span class="text-gray-500 text-sm">/mes</span>
                        @endif
                    </div>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $plan->max_projects == -1 ? 'Proyectos ilimitados' : $plan->max_projects . ' proyectos' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $plan->max_members == -1 ? 'Miembros ilimitados' : $plan->max_members . ' miembros' }}
                        </li>
                    </ul>
                    <div class="mt-6">
                        @if($currentPlan?->id === $plan->id)
                            <span class="block w-full text-center px-4 py-2 text-sm font-medium text-brand-700 bg-brand-50 rounded-md">Plan actual</span>
                        @else
                            <button wire:click="changePlan({{ $plan->id }})"
                                    wire:confirm="¿Cambiar al plan {{ $plan->name }}?"
                                    class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-brand-600 rounded-md hover:bg-brand-700 transition">
                                {{ $plan->price > ($currentPlan?->price ?? 0) ? 'Mejorar plan' : 'Cambiar plan' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
