<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow — Gestión de Proyectos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-indigo-600">TaskFlow</div>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">Empezar gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
            Gestiona tus proyectos<br>
            <span class="text-indigo-600">como un profesional</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Tableros Kanban, equipos, seguimiento de tareas. Todo lo que necesitas para llevar tus proyectos al siguiente nivel.
        </p>
        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 shadow-lg">
            Empezar gratis &rarr;
        </a>
    </section>

    <!-- Features -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Todo lo que necesitas</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-xl font-semibold mb-2">Tableros Kanban</h3>
                    <p class="text-gray-600">Arrastra y suelta tareas entre columnas. Visualiza el progreso de tu equipo al instante.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-semibold mb-2">Equipos</h3>
                    <p class="text-gray-600">Invita a tu equipo, asigna roles y colabora en tiempo real en todos tus proyectos.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-xl font-semibold mb-2">Analytics</h3>
                    <p class="text-gray-600">Métricas de productividad, velocidad del equipo y seguimiento de deadlines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-4">Planes y Precios</h2>
            <p class="text-gray-600 text-center mb-12">Empieza gratis, escala cuando lo necesites</p>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Free -->
                <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Free</h3>
                    <div class="text-4xl font-extrabold mb-4">$0<span class="text-lg text-gray-500 font-normal">/mes</span></div>
                    <ul class="space-y-3 text-gray-600 mb-8">
                        <li>✓ 3 proyectos</li>
                        <li>✓ 2 miembros</li>
                        <li>✓ Tableros básicos</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center bg-gray-100 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">Empezar gratis</a>
                </div>

                <!-- Pro -->
                <div class="bg-indigo-600 rounded-2xl shadow-xl p-8 text-white transform scale-105">
                    <div class="text-sm font-bold uppercase tracking-wider mb-2 text-indigo-200">Popular</div>
                    <h3 class="text-xl font-bold mb-2">Pro</h3>
                    <div class="text-4xl font-extrabold mb-4">$12<span class="text-lg text-indigo-200 font-normal">/mes</span></div>
                    <ul class="space-y-3 text-indigo-100 mb-8">
                        <li>✓ 20 proyectos</li>
                        <li>✓ 10 miembros</li>
                        <li>✓ Integraciones</li>
                        <li>✓ Soporte prioritario</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-50">Elegir Pro</a>
                </div>

                <!-- Business -->
                <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Business</h3>
                    <div class="text-4xl font-extrabold mb-4">$29<span class="text-lg text-gray-500 font-normal">/mes</span></div>
                    <ul class="space-y-3 text-gray-600 mb-8">
                        <li>✓ Proyectos ilimitados</li>
                        <li>✓ Miembros ilimitados</li>
                        <li>✓ Analytics avanzados</li>
                        <li>✓ Campos personalizados</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center bg-gray-100 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">Elegir Business</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center">
        <p>&copy; {{ date('Y') }} TaskFlow. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
