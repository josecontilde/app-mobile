<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h2 id="name"></h2>
</div>
<div id="tasks">
</div>
<script>
    //obtener el token de autenticación en el localStorage
    const token = localStorage.getItem('sanctum_token');
    //si no hay token, redirigir a la página de inicio de sesión
    if (!token) {
        window.location.href = '/login';
    }

    async function fetchUserData() {
        try {
            const response = await fetch('/api/user', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al cargar usuario');
            }

            const data = await response.json(); // Convertir la respuesta a un objeto
            
            return data.user; // Retornar el objeto si es necesario
        } catch (error) {
            console.error('Error:', error.message);
        }
    }

    // Función para actualizar el nombre del usuario
    async function updateUserName() {
        const user = await fetchUserData(); // Esperar a que la promesa se resuelva

        // Obtener el nombre del usuario
        const name = document.getElementById('name');
        if (user && user.name) { // Verificar si el usuario y el nombre existen
            name.textContent = 'Bienvenido, ' + user.name;
        } else {
            name.textContent = 'Bienvenido, Usuario';
        }
    }

    async function fetchTeams() {
        try {
            const response = await fetch('/api/team', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al cargar tareas');
            }

            const data = await response.json(); // Convertir la respuesta a un objeto
            console.log(data); // Aquí tienes el objeto con las tareas
        } catch (error) {
            console.error('Error:', error.message);
        }
    }

    fetchTeams(); // Llamar a la función para cargar las tareas
    updateUserName(); // Llamar a la función para actualizar el nombre del usuario
</script>
@endsection