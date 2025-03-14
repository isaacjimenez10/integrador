<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Asegúrate de incluir el token CSRF -->
    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .dashboard-container {
            animation: fadeIn 0.5s ease-in-out;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem;
            z-index: 10;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Barra de navegación mejorada -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="#" class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i> Panel Admin
                </a>
                <div class="flex space-x-6 items-center">
                    <a href="{{ url('/configuracion') }}" class="text-gray-700 hover:text-blue-600 flex items-center transition duration-300">
                        <i class="fas fa-cog mr-2"></i> Configuración
                    </a>
                    <a href="{{ url('/sensores') }}" class="text-gray-700 hover:text-blue-600 flex items-center transition duration-300">
                        <i class="fas fa-microchip mr-2"></i> Sensores
                    </a>
                    <a href="{{ url('/lecturas') }}" class="text-gray-700 hover:text-blue-600 flex items-center transition duration-300">
                        <i class="fas fa-chart-line mr-2"></i> Lecturas
                    </a>
                </div>
                <div class="flex items-center space-x-4 relative">
                    <div class="dropdown">
                        <button class="flex items-center text-gray-800 hover:text-blue-600 focus:outline-none transition duration-300">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span>Bienvenido, {{ auth()->user()->nombre }}</span>
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <div class="dropdown-menu mt-2 py-2 w-48">
                            <form action="{{ route('admin.logout') }}" method="POST" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition duration-300">
                                @csrf
                                <button type="submit" class="w-full text-left">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="dashboard-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Mensajes de éxito y error -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar errores de validación -->
        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard de Administrador</h1>

        <!-- Cantidad de Clientes Registrados -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Cantidad de Clientes Registrados</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $clientes->total() }}</p>
        </div>

        <!-- Lista de Clientes -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Lista de Clientes</h2>
            <div class="flex space-x-4 mb-4">
                <button id="exportExcel" class="bg-blue-500 text-white px-4 py-2 rounded">Exportar a Excel</button>
                <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" class="inline-block">
                    @csrf
                    <input type="file" name="file" id="importExcel" accept=".xlsx, .xls" class="hidden" />
                    <label for="importExcel" class="bg-green-500 text-white px-4 py-2 rounded cursor-pointer">Importar desde Excel</label>
                </form>

            </div>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Correo</th>
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Password</th>                            
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Estado</th>
                            <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $cliente->id }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $cliente->email }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $cliente->password }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <span class="{{ $cliente->bloqueado ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $cliente->bloqueado ? 'Bloqueado' : 'Activo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <div class="action-buttons">
                                    <a href="{{ url('clientes/'.$cliente->id.'/edit') }}" class="text-blue-600 hover:text-blue-800 transition duration-300">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ url('clientes/'.$cliente->id.'/bloquear') }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 transition duration-300">
                                            <i class="fas fa-lock"></i> {{ $cliente->bloqueado ? 'Desbloquear' : 'Bloquear' }}
                                        </button>
                                    </form>
                                    <form action="{{ url('clientes/'.$cliente->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition duration-300">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>

        <!-- Gráfica de Registros Mensuales -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Registros Mensuales</h2>
            <canvas id="registrosMensualesChart" class="w-full h-48"></canvas> <!-- Ajusté la altura a h-48 -->
        </div>
    </div>

    <script>
        // Gráfica de registros mensuales
        const registrosCtx = document.getElementById('registrosMensualesChart').getContext('2d');
        const registrosMensualesChart = new Chart(registrosCtx, {
            type: 'bar',
            data: {
                labels: @json($meses), // Utiliza los nombres de los meses
                datasets: [{
                    label: 'Registros Mensuales',
                    data: @json($registrosPorMes), // Utiliza los datos de registros por mes
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            }
        });

        // Exportar a Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            const ws = XLSX.utils.table_to_sheet(document.querySelector('table'));
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Clientes');
            XLSX.writeFile(wb, 'clientes.xlsx');
        });

        // Importar desde Excel
        document.getElementById('importExcel').addEventListener('change', function() {
            this.form.submit(); // Envía el formulario automáticamente cuando se selecciona un archivo
        });
    </script>
</body>
</html>