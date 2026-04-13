<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskFlow') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 flex" x-data="{ sidebarOpen: false }">

            <!-- Sidebar (mobile overlay) -->
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden">
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     @click="sidebarOpen = false"
                     class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div class="relative flex w-64 flex-col bg-brand-900 h-full">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="sidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @include('layouts.partials.sidebar-content')
                </div>
            </div>

            <!-- Sidebar (desktop) -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex w-64 flex-col">
                    <div class="flex min-h-0 flex-1 flex-col bg-brand-900">
                        @include('layouts.partials.sidebar-content')
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex flex-1 flex-col overflow-hidden">
                <!-- Top bar -->
                <div class="flex h-16 flex-shrink-0 border-b border-gray-200 bg-white">
                    <button @click="sidebarOpen = true" class="border-r border-gray-200 px-4 text-gray-500 lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="flex flex-1 justify-between px-4 sm:px-6">
                        @if (isset($header))
                            <div class="flex items-center">
                                <h1 class="text-xl font-semibold text-gray-900">{{ $header }}</h1>
                            </div>
                        @else
                            <div></div>
                        @endif
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->currentTeam)
                                <span class="text-sm text-gray-500">{{ auth()->user()->currentTeam->name }}</span>
                            @endif
                            <livewire:layout.navigation />
                        </div>
                    </div>
                </div>

                <!-- Page content -->
                <main class="flex-1 overflow-y-auto">
                    <!-- Flash messages -->
                    @if(session('error'))
                        <div class="mx-4 mt-4 rounded-md bg-red-50 p-4 sm:mx-6">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="mx-4 mt-4 rounded-md bg-green-50 p-4 sm:mx-6">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
