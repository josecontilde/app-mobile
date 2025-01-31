<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Equipos')

@section('content')

<div id="container-tasks" class="container mx-auto p-4">
    <button id="new" class="bg-blue-500 text-white px-4 py-2  m-4 rounded-md hover:bg-blue-600">
        new
    </button>
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

    async function verifyMember(name) {
        try {
            const response = await fetch('/api/users', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al verificar miembro');
            }

            const data = await response.json(); // Convertir la respuesta a un objeto
            const users = data.users;

            const user = users.find(user => user.name === name);
            if (!user) {
                alert('Usuario no encontrado');
                return;
            }
            return user;
        } catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar verificar el miembro');
        }
    }

    async function addMember(teamId, userId) {
        try {
            const response = await fetch(`/api/team/${teamId}/member`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    user_id : userId,
                    role : 'member'
                })
            });

            const data = await response.json();

            if (!response.ok) {
                console.error('Error del servidor:', data);
                throw new Error(data.message || 'Error al agregar miembro');
            }

            alert('Miembro agregado correctamente');
            
        } catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar agregar el miembro');
        }
    }

    async function updateTeam(teamId, newName) {
        try {
            const response = await fetch(`/api/team/${teamId}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify({
                    name: newName
                })
            });

            if (!response.ok) {
                throw new Error('Error al actualizar el equipo');
            }

            fetchTeams(); // Recargar la lista de equipos después de actualizar
        }
        catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar actualizar el equipo');
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

            const tasksContainer = document.getElementById('tasks'); // Contenedor de tareas
            tasksContainer.innerHTML = ''; // Limpiar el contenedor antes de insertar nuevos datos

            teams.forEach(team => {
                const teamDiv = document.createElement('div');
                teamDiv.className = 'team p-4 bg-white rounded-lg shadow-sm';

                const teamName = document.createElement('h3');
                teamName.className = 'text-xl font-semibold text-gray-700 mb-3';
                teamName.textContent = team.name;

                const leaveButton = document.createElement('button');
                leaveButton.className = 'bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600';
                leaveButton.textContent = team.pivot.role === 'owner' ? 'Eliminar' : 'Salir';
                leaveButton.onclick = () => team.pivot.role === 'owner' ? deleteTeam(team.id) : leaveTeam(team.id);

                const updateButton = document.createElement('button');
                updateButton.className = 'bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600';
                updateButton.textContent = 'Editar';
                updateButton.onclick = () => {
                    const newName = prompt('Ingresa el nuevo nombre del equipo');
                    if (!newName) {
                        return; // Si el usuario cancela, no hacer nada
                    }
                    updateTeam(team.id, newName);
                }

                const newMemberButton = document.createElement('button');
                newMemberButton.className = 'bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600';
                newMemberButton.textContent = 'Agregar miembro';
                newMemberButton.onclick = async () => {
                    const name = prompt('Ingresa el nombrer del nuevo miembro');

                    if (!name) {
                        return; // Si el usuario cancela, no hacer nada
                    }

                    const user = await verifyMember(name);
                    if (!user) {
                        return;
                    }
                    addMember(team.id, user.id);
                }
                const viewButton = document.createElement('button');
                viewButton.className = 'bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600';
                viewButton.textContent = 'Ver';
                viewButton.onclick = () => window.location.href = `/team/${team.id}`;

                teamDiv.appendChild(teamName);
                teamDiv.appendChild(leaveButton); // Agregar el botón al div del equipo
                team.pivot.role === 'owner' ? teamDiv.appendChild(newMemberButton) : null;
                team.pivot.role === 'owner' ? teamDiv.appendChild(updateButton) : null;
                teamDiv.appendChild(viewButton);
                tasksContainer.appendChild(teamDiv);
            });

        } catch (error) {
            console.error('Error:', error.message);
        }
    }

    async function leaveTeam(teamId) {
        if (!confirm('¿Estás seguro de que quieres salir de este equipo?')) {
            return; // Si el usuario cancela, no hacer nada
        }

        try {
            const response = await fetch(`/api/team/${teamId}/leave`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            console.log(response);

            if (!response.ok) {
                throw new Error('Error al salir del equipo');
            }

            
            alert('Has salido del equipo correctamente');
            fetchTeams(); // Recargar la lista de equipos después de salir
        } catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar salir del equipo');
        }
    }

    async function deleteTeam(teamId) {
        if (!confirm('¿Estás seguro de que quieres eliminar este equipo?')) {
            return; // Si el usuario cancela, no hacer nada
        }

        try {
            const response = await fetch(`/api/team/${teamId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            if (!response.ok) {
                throw new Error('Error al eliminar el equipo');
            }

            const result = await response.json();
            alert(result.message || 'Equipo eliminado correctamente');
            fetchTeams(); // Recargar la lista de equipos después de eliminar
        } catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar eliminar el equipo');
        }
    }

    const newButton = document.getElementById('new');
    newButton.onclick = () => {
        const teamName = prompt('Ingresa el nombre del nuevo equipo');

        if (!teamName) {
            return; // Si el usuario cancela, no hacer nada
        }

        createTeam(teamName);
    }

    async function createTeam(teamName) {
        try {
            const response = await fetch('/api/team', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify({
                    name: teamName
                })
            });

            if (!response.ok) {
                throw new Error('Error al crear el equipo');
            }

            const result = await response.json();

            alert(result.message || 'Equipo creado correctamente');
            fetchTeams(); // Recargar la lista de equipos después de crear
        } catch (error) {
            console.error('Error:', error.message);
            alert('Hubo un error al intentar crear el equipo');
        }
    }



    fetchTeams(); // Llamar a la función para cargar las tareas
</script>
@endsection