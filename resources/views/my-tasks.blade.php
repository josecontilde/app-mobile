<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Equipos y Tareas')

@section('content')

<div id="container-tasks" class="container mx-auto p-4">
    <div id="tasks" class="space-y-4">
        <!-- Aquí se insertarán los equipos y tareas -->
    </div>
</div>
<script>
    //obtener el token de autenticación en el localStorage
    const token = localStorage.getItem('sanctum_token');
    //si no hay token, redirigir a la página de inicio de sesión
    if (!token) {
        window.location.href = '/login';
    }

    async function fetchUser() {
        try {
            const response = await fetch(`/api/user`, {
                method: 'GET', // Método HTTP
                headers: {
                    'Authorization': `Bearer ${token}`, // Incluir el token en el encabezado
                    'Content-Type': 'application/json', // Especificar el tipo de contenido
                },
            });

            if (!response.ok) {
                throw new Error(`Error`);
            }

            const data = await response.json();

            return data.user;
        } catch (error) {
            console.error('Error:', error);
            throw error;
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
            const teams = data.teams;
            const user = await fetchUser();


            const tasksContainer = document.getElementById('tasks'); // Contenedor de tareas
            tasksContainer.innerHTML = ''; // Limpiar el contenedor antes de insertar nuevos datos

            teams.forEach(team => {

                const teamDiv = document.createElement('div');
                teamDiv.className = 'team p-4 bg-white rounded-lg shadow-sm';

                const headTeamDiv = document.createElement('div');
                headTeamDiv.className = 'flex justify-between items-center';

                const teamName = document.createElement('h3');
                teamName.className = 'text-xl font-semibold text-gray-700 mb-3';
                teamName.textContent = team.name;

                const taskNew = document.createElement('button');
                taskNew.className = 'bg-blue-500 text-white px-4 py-2  m-4 rounded-md hover:bg-blue-600';
                taskNew.textContent = 'Agregar tarea';
                taskNew.addEventListener('click', () => {
                    window.location.href = `/team/${team.id}/task/new`;
                });

                const tasksList = document.createElement('ul');
                tasksList.className = 'tasks-list space-y-2';

                if (team.tasks && team.tasks.length > 0) {
                    team.tasks.forEach(task => {
                        const taskItem = document.createElement('li');
                        taskItem.className = 'task-item p-3 bg-gray-50 rounded-md';

                        // Crear un enlace que apunte a la URL de la tarea específica
                        const taskLink = document.createElement('a');
                        taskLink.href = `/team/${team.id}/task/${task.id}`; // Ajusta la URL según tu estructura de rutas
                        taskLink.className = 'block'; // Asegura que el enlace ocupe todo el espacio del li

                        const creador = task.creator.id === user.id ? 'Creado por ti' : task.creator.name;

                        // Contenido de la tarea
                        taskLink.innerHTML = `
        <strong class="text-lg font-medium text-gray-800">${task.name}</strong>
        <p class="text-sm text-gray-600 mt-1">${task.description}</p>
        <small class="text-xs text-gray-500">Estado: ${task.status}</small><br>
        <small class="text-xs text-gray-500">Creado por: ${creador}</small>
    `;
                        

                        // Agregar el enlace al elemento de la tarea
                        taskItem.appendChild(taskLink);

                        // Agregar la tarea a la lista
                        tasksList.appendChild(taskItem);

                        const taskDelete = document.createElement('button');
                        taskDelete.className = 'block text-red-500 text-sm ';
                        taskDelete.textContent = 'Eliminar tarea';
                        taskDelete.addEventListener('click', async () => {
                            const confirmDelete = confirm('¿Estás seguro de eliminar esta tarea?');
                            if (confirmDelete) {
                                const response = await fetch(`/api/team/${team.id}/task/${task.id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Authorization': `Bearer ${token}`,
                                        'Content-Type': 'application/json',
                                    },
                                });
                                console.log(response);

                                if (!response.ok) {
                                    throw new Error('Error al eliminar la tarea');
                                }

                                fetchTeams();
                            }
                        });
                        task.creator.id === user.id ? taskItem.appendChild(taskDelete) : null;
                    });
                } else {
                    const noTasksItem = document.createElement('li');
                    noTasksItem.className = 'task-item p-3 bg-gray-50 rounded-md text-center text-gray-500';
                    noTasksItem.textContent = 'No hay tareas en este equipo.';
                    tasksList.appendChild(noTasksItem);
                }


                headTeamDiv.appendChild(teamName);
                headTeamDiv.appendChild(taskNew);
                teamDiv.appendChild(headTeamDiv);
                teamDiv.appendChild(tasksList);
                tasksContainer.appendChild(teamDiv);
            });

        } catch (error) {
            console.error('Error:', error.message);
        }
    }


    fetchTeams(); // Llamar a la función para cargar las tareas
</script>
@endsection