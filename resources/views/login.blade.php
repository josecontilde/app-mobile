<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <!-- Encabezado -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido</h1>
            <p class="text-gray-500">Ingresa a tu cuenta</p>
        </div>

        <!-- Formulario -->
        <form id="loginForm" class="space-y-6">
            
            <!-- Email -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input
                        type="email"
                        placeholder="tucorreo@ejemplo.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                        name="email">
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Contraseña</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input
                        type="password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        minlength="6"
                        required
                        name="password">
                </div>
            </div>



            <!-- Botón de Login -->
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                Ingresar
            </button>

        </form>
    </div>
    <script>
        
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: document.querySelector('[name="email"]').value,
                    password: document.querySelector('[name="password"]').value
                })
            });

            if (response.ok) {
                const data = await response.json();

                // Almacenar token en localStorage
                localStorage.setItem('sanctum_token', data.token);

                // Redirigir al dashboard
                window.location.href = '/dashboard';
            } else {
                alert('Credenciales inválidas');
            }
        });
    </script>
</body>

</html>