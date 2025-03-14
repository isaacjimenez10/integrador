<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Net Nexus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 18px;
        }
        a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Mi Perfil</h1>
        <p>Bienvenido a tu perfil de cliente. Aquí puedes gestionar tu información personal.</p>
        <a href="{{ route('cliente.dashboard') }}">Volver al Dashboard</a>
    </div>
</body>
</html>