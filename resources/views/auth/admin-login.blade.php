<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-container {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-gray-100 to-blue-200">
    <div class="login-container w-full max-w-md p-8 bg-white shadow-2xl rounded-lg transform transition-transform duration-300 hover:scale-105">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Iniciar Sesión Administrador</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg border border-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-3 mt-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                    placeholder="Ingrese su correo" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-3 mt-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                    placeholder="Ingrese su contraseña" required>
            </div>

            <button type="submit" 
                class="w-full px-4 py-3 text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                Iniciar Sesión
            </button>
        </form>
    </div>
</body>
</html>