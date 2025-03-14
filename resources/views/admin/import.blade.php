<!DOCTYPE html>
<html>
<head>
    <title>Importar Clientes</title>
</head>
<body>
    <h1>Importar Clientes desde Excel</h1>
    <form method="POST" action="{{ route('admin.import') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Selecciona el archivo Excel:</label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls">
        </div>
        <button type="submit">Importar Clientes</button>
    </form>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
</body>
</html>