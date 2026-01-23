<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - Gestión BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; padding-bottom: 80px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .card:hover { transform: scale(1.01); }

        /* --- NAVEGACIÓN MÓVIL --- */
        .nav-mobile { 
            background: white; 
            border-top: 1px solid #dee2e6; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            z-index: 1000; 
            display: flex;
            justify-content: space-around;
        }

        .nav-link-mobile { 
            text-align: center; 
            font-size: 0.75rem; 
            color: #6c757d; 
            text-decoration: none; 
            padding: 10px 0; 
            flex: 1; 
            transition: all 0.3s ease; 
        }

        .nav-link-mobile i { 
            display: block; 
            font-size: 1.4rem; 
            margin-bottom: 2px; 
            transition: transform 0.3s ease, color 0.3s ease; 
        }

        .nav-link-mobile:hover i {
            transform: translateY(-5px);
            color: #0d6efd;
            text-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .nav-link-mobile.active { 
            color: #0d6efd; 
            font-weight: bold; 
        }
        
        .nav-link-mobile.active i {
            color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <h4 class="mb-4"><i class="fas fa-tools text-primary"></i> Centro de Respaldos</h4>

    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-info-circle me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12">
            <div class="card p-4 text-center">
                <i class="fas fa-file-export fa-3x text-success mb-3"></i>
                <h5>Generar Respaldo</h5>
                <p class="text-muted small">Crea una copia de seguridad .SQL de toda tu base de datos.</p>
                <form action="{{ route('backup.create') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 mt-2 py-2 fw-bold">Descargar .SQL</button>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="card p-4">
                <div class="text-center"><i class="fas fa-upload fa-3x text-warning mb-3"></i></div>
                <h5 class="text-center">Restaurar Datos</h5>
                <p class="text-center text-muted small">Selecciona un archivo para sobrescribir la BD actual.</p>
                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="backup_file" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-warning w-100 text-white py-2 fw-bold" onclick="return confirm('¿Restaurar ahora? Esto reemplazará los datos actuales.')">Subir y Restaurar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="nav-mobile">
    <a href="{{ route('home') }}" class="nav-link-mobile {{ Route::is('home') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="{{ route('backup.index') }}" class="nav-link-mobile {{ Route::is('backup.index') ? 'active' : '' }}">
        <i class="fas fa-tools"></i> Mantenimiento
    </a>
    <a href="{{ route('personas.index') }}" class="nav-link-mobile {{ Route::is('personas.index') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Personas
    </a>
    <a href="{{ route('empleos.index') }}" class="nav-link-mobile {{ Route::is('empleos.index') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Empleos
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>