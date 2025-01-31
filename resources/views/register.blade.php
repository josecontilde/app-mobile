<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <!-- Encabezado -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Crear Cuenta</h1>
            <p class="text-gray-500">Regístrate para comenzar</p>
        </div>

        <!-- Formulario -->
        <form class="space-y-6">
            <!-- Nombre y Apellido -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nombre</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            placeholder="Juan" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required
                        >
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Apellido</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            placeholder="Pérez" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input 
                        type="email" 
                        placeholder="tucorreo@ejemplo.com" 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                    >
                </div>
            </div>

            <!-- Contraseña y Confirmación -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            minlength="6"
                            required
                            id="password"
                        >
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Confirmar Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            minlength="6"
                            required
                            id="password-confirm"
                        >
                    </div>
                </div>
            </div>

            <!-- Términos y Condiciones -->
            <div class="flex items-center">
                <input 
                    id="terms" 
                    type="checkbox" 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    required
                >
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    Acepto los 
                    <a href="#" class="text-blue-600 hover:text-blue-800">Términos y Condiciones</a>
                </label>
            </div>

            <!-- Botón de Registro -->
            <button 
                type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
            >
                Registrarse
            </button>

            <!-- Enlace a Login -->
            <div class="text-center text-sm text-gray-600 mt-6">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Iniciar Sesión</a>
            </div>
        </form>
    </div>

    <!-- Validación contraseña -->
    <script>
        const password = document.getElementById('password')
        const confirmPassword = document.getElementById('password-confirm')

        function validatePassword() {
            if(password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Las contraseñas no coinciden")
            } else {
                confirmPassword.setCustomValidity('')
            }
        }

        password.onchange = validatePassword
        confirmPassword.onkeyup = validatePassword
    </script>
</body>
    
</body>
</html>