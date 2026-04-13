<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition">
        <div>{{ auth()->user()->name }}</div>
        <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
    </button>
    <div x-show="open" @click.away="open = false" x-cloak
         class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
        <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
        <button wire:click="logout" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
    </div>
</div>
