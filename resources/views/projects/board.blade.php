<x-app-layout>
    <x-slot name="header">{{ $project->name }}</x-slot>

    <livewire:kanban-board :board="$board" />
</x-app-layout>
