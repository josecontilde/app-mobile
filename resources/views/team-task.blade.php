@extends('layouts.app')

@section('title', 'Tarea')

@section('content')


<div id="task" class="space-y-4">
    <!-- Aquí se insertarán el task individual -->
</div>
<script>
    const urlSegments = window.location.href.split('/'); // Divide la URL en segmentos
    const teamId = urlSegments[urlSegments.length - 3]; // Obtiene el ID del equipo
    const taskId = urlSegments[urlSegments.length - 1]; // Obtiene el ID de la tarea
    console.log(taskId);

    async function fetchTask(teamId, taskId) {
        const token = localStorage.getItem('sanctum_token');
        if (!token) {
            throw new Error('No se encontró el token de autenticación');
        }

        try {
            const response = await fetch(`http://localhost:8000/api/team/${teamId}/task/${taskId}`, {
                method: 'GET', // Método HTTP
                headers: {
                    'Authorization': `Bearer ${token}`, // Incluir el token en el encabezado
                    'Content-Type': 'application/json', // Especificar el tipo de contenido
                    'Accept': 'application/json', // Especificar el tipo de contenido
                },
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            return data.task;
        } catch (error) {
            console.error('Error:', error);
            throw error;
        }
    }

    async function renderTask() {
        const urlSegments = window.location.href.split('/');
        const teamId = urlSegments[urlSegments.length - 3]; // Extraer teamId
        const taskId = urlSegments[urlSegments.length - 1]; // Extraer taskId

        const task = await fetchTask(teamId, taskId); // Obtener los detalles de la tarea

        if (task) {
            const taskContainer = document.getElementById('task');
            taskContainer.innerHTML = `
            <div class="task-item p-4 bg-white rounded-lg shadow-md">
                <strong class="text-xl font-semibold text-gray-800">${task.name}</strong>
                <p class="text-md text-gray-600 mt-2">${task.description}</p>
                <small class="text-sm text-gray-500">Estado: ${task.status}</small>
                <small class="block text-sm text-gray-500 mt-2">Fecha de creación: ${new Date(task.created_at).toLocaleDateString()}</small>
            </div>
        `;
        } else {
            // Mostrar un mensaje si no se encuentra la tarea
            const taskContainer = document.getElementById('task');
            taskContainer.innerHTML = `<p class="text-red-500">No se pudo cargar la tarea.</p>`;
        }
    }

    // Llamar a la función para renderizar la tarea
    renderTask();
</script>
@endsection