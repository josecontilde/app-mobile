<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Manager</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Task Manager</h2>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-100 rounded">Dashboard</a>
                    <a href="{{ route('my-tasks') }}" class="block p-2 hover:bg-gray-100 rounded">Mis Tareas</a>
                    <a href="{{ route('my-teams') }}" class="block p-2 hover:bg-gray-100 rounded">Equipos</a>
                </nav>

                <!-- Equipos -->
                <div class="mt-8">
                    <h3 class="font-semibold mb-2">Mis Equipos</h3>
                    <div id="teamsDahsboard" class="space-y-2">

                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">@yield('title')</h1>
                <form action="/api/logout" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Cerrar sesión
                    </button>
                </form>
            </header>

            <div class="bg-white rounded-lg shadow p-6">
                @yield('content')
            </div>
        </main>
    </div>
    <script>

        async function fetchTeamsDash() {
            try {
                const response = await fetch('/api/team', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al cargar tareas');
                }
                const data = await response.json(); // Convertir la respuesta a un objeto
                return data.teams;

            } catch (error) {
                console.error('Error:', error.message);
            }
        }

        async function renderTeamsDashboard() {
            const teams = await fetchTeamsDash();
            
            const teamsDashboard = document.getElementById('teamsDahsboard'); 
            teams.forEach(team => {
                const teamName = document.createElement('a');
                teamName.className = 'block p-3 border border-blue-500 text-blue-500 font-semibold rounded-lg hover:bg-blue-500 hover:text-white transition duration-300';

                teamName.textContent = team.name;
                teamName.href = `/team/${team.id}`;

                teamsDashboard.appendChild(teamName);

            });
        }

        renderTeamsDashboard();
    </script>
</body>

</html>