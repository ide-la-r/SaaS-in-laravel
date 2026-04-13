<div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
    <div class="flex flex-shrink-0 items-center px-4">
        <span class="text-2xl font-bold text-white">TaskFlow</span>
    </div>
    <nav class="mt-8 flex-1 space-y-1 px-2">
        <a href="{{ route('dashboard') }}" wire:navigate
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('projects.index') }}" wire:navigate
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('projects.*') ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            Proyectos
        </a>
        <a href="{{ route('team.members') }}" wire:navigate
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('team.*') ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Equipo
        </a>
        <a href="{{ route('billing') }}" wire:navigate
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('billing') ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Facturación
        </a>
    </nav>
</div>

<!-- User info at bottom -->
<div class="flex flex-shrink-0 border-t border-brand-800 p-4">
    <div class="flex items-center w-full">
        <div class="flex-shrink-0">
            <div class="h-8 w-8 rounded-full bg-brand-600 flex items-center justify-center text-white text-sm font-medium">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
        <div class="ml-3 min-w-0 flex-1">
            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-brand-300 truncate">{{ auth()->user()->email }}</p>
        </div>
    </div>
</div>
