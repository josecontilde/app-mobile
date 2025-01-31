@extends('layouts.app')

@section('title', 'Equipo y miembros')

@section('content')


<div id="miembros" class="space-y-4">
    <!-- Aquí se insertarán el task individual -->
</div>
<script>
    const urlSegments = window.location.href.split('/'); // Divide la URL en segmentos
    const teamId = urlSegments[urlSegments.length - 1]; // Obtiene el ID del equipo
    const token = localStorage.getItem('sanctum_token');

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



    async function fetchMembers(teamId, taskId) {

        if (!token) {
            throw new Error('No se encontró el token de autenticación');
        }

        try {
            const response = await fetch(`/api/team/${teamId}/member`, {
                method: 'GET', // Método HTTP
                headers: {
                    'Authorization': `Bearer ${token}`, // Incluir el token en el encabezado
                    'Content-Type': 'application/json', // Especificar el tipo de contenido
                },
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            return data.members;
        } catch (error) {
            console.error('Error:', error);
            throw error;
        }
    }



    async function renderMembers() {
        try {
            const members = await fetchMembers(teamId); // Obtener los miembros del equipo
            const user = await fetchUser(teamId);
            const isOwner = members.find(member => member.id === user.id).pivot.role === 'owner';


            const miembrosContainer = document.getElementById('miembros');
            miembrosContainer.innerHTML = ''; // Limpiar el contenedor antes de insertar nuevos datos


            if (!members) {
                miembrosContainer.innerHTML = `<p class="text-gray-600">No hay miembros en este equipo.</p>`;
                return;
            }

            members.forEach(member => {
                const memberDiv = document.createElement('div');
                memberDiv.className = 'member-item p-4 bg-white rounded-lg shadow-md';

                const memberName = document.createElement('strong');
                memberName.className = 'text-lg font-medium text-gray-800';
                memberName.textContent = member.name;

                const memberRole = document.createElement('p');
                memberRole.className = 'text-sm text-gray-600 mt-1';
                memberRole.textContent = `Rol: ${member.pivot.role}`;

                const memberEmail = document.createElement('p');
                memberEmail.className = 'text-sm text-gray-600 mt-1';
                memberEmail.textContent = `Email: ${member.email}`;

                const memberDelete = document.createElement('a');
                memberDelete.className = 'text-sm text-red-500 mt-1 cursor-pointer hover:underline';
                memberDelete.textContent = `Eliminar miembro`;
                memberDelete.onclick = async () => {
                    if (confirm('¿Estás seguro de eliminar este miembro?')) {
                        try {
                            const response = await fetch(`/api/team/${teamId}/member/${member.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Content-Type': 'application/json',
                                },
                            });
                            if (response.ok) {
                                renderMembers();
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                };


                memberDiv.appendChild(memberName);
                memberDiv.appendChild(memberRole);
                memberDiv.appendChild(memberEmail);
                isOwner ? memberDiv.appendChild(memberDelete) : null;
                miembrosContainer.appendChild(memberDiv);
            });
        } catch (error) {
            console.error('Error al renderizar miembros:', error);
            const miembrosContainer = document.getElementById('miembros');
            miembrosContainer.innerHTML = `<p class="text-red-500">Hubo un error al cargar los miembros.</p>`;
        }
    }


    renderMembers();
</script>
@endsection