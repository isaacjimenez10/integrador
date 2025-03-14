<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cliente - Invernadero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1483794344563-d27a8d18014e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: slideUp 1s ease-in-out;
        }

        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        h1 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #27ae60;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #219653;
        }

        .form-footer {
            margin-top: 20px;
            color: #666;
        }

        .form-footer a {
            color: #27ae60;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #219653;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Acceso al Invernadero</h1>

        @if(session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif


        <form action="{{ route('cliente.login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <div class="form-footer">
            <p>¿No tienes una cuenta? <a href="{{ route('cliente.register') }}">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>