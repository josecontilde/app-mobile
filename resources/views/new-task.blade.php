@extends('layouts.app')

@section('title', 'Nueva tarea')

@section('content')

<form id="taskForm" class="m-4">

    <!-- Campo: Nombre de la tarea -->
    <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-2">Nombre</label>
        <input type="text" name="name" id="name" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ingresa el nombre de la tarea">
    </div>

    <!-- Campo: Descripción de la tarea -->
    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium mb-2">Descripción</label>
        <textarea name="description" id="description" rows="4" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Describe la tarea"></textarea>
    </div>

    <!-- Campo: Estado de la tarea -->
    <div class="mb-4">
        <label for="status" class="block text-gray-700 font-medium mb-2">Estado</label>
        <select name="status" id="status" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="pending">Pendiente</option>
            <option value="in_progress">En progreso</option>
            <option value="completed">Completada</option>
        </select>
    </div>

    <!-- Campo: Fecha de vencimiento -->
    <div class="mb-4">
        <label for="due_date" class="block text-gray-700 font-medium mb-2">Fecha de vencimiento</label>
        <input type="date" name="due_date" id="due_date" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Campo: Prioridad -->
    <div class="mb-4">
        <label for="priority" class="block text-gray-700 font-medium mb-2">Prioridad</label>
        <select name="priority" id="priority" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="low">Baja</option>
            <option value="medium">Media</option>
            <option value="high">Alta</option>
        </select>
    </div>

    <!-- Botón de envío -->
    <div class="mt-6">
        <button type="submit"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Crear tarea
        </button>
    </div>
</form>
<script>
    //obtener el token de autenticación en el localStorage
    const token = localStorage.getItem('sanctum_token');
    //si no hay token, redirigir a la página de inicio de sesión
    if (!token) {
        window.location.href = '/login';
    }

    const urlSegments = window.location.href.split('/'); // Divide la URL en segmentos
    const teamId = urlSegments[urlSegments.length - 3]; // Obtiene el ID del equipo

    const form = document.getElementById('taskForm');
    form.addEventListener('submit', async function(event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario

        // Obtener los datos del formulario
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        console.log(data);

        try {
            const response = await fetch(`/api/team/${teamId}/task`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(data),
            });

            console.log(response);
            if (!response.ok) {
                throw new Error('Error al crear la tarea');
            }
            const result = await response.json();

            window.location.href = `/my-tasks`;
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endsection