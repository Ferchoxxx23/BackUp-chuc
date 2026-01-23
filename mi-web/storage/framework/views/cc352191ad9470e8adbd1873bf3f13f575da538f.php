<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Gestión BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; padding-bottom: 80px; }
        
        /* Estilos de Tarjetas */
        .card-dash { 
            border: none; 
            border-radius: 15px; 
            transition: all 0.3s ease; 
        }
        .card-dash:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; 
        }
        .card-dash:active { transform: scale(0.95); }
        
        .welcome-section { 
            background: linear-gradient(135deg, #0d6efd, #0043a8); 
            color: white; 
            border-radius: 0 0 25px 25px; 
            padding: 40px 20px; 
        }

        /* --- NAVEGACIÓN MÓVIL MODIFICADA --- */
        .nav-mobile { 
            background: white; 
            border-top: 1px solid #dee2e6; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            z-index: 1000; 
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

        /* EFECTO HOVER EN ICONOS */
        .nav-link-mobile:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
        }

        .nav-link-mobile:hover i {
            transform: translateY(-5px); /* El icono sube al pasar el mouse */
            color: #0d6efd;
            text-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        /* CLASE ACTIVA */
        .nav-link-mobile.active { 
            color: #0d6efd; 
            font-weight: bold; 
        }

        .stat-icon { font-size: 2rem; opacity: 0.3; position: absolute; right: 15px; top: 15px; }
    </style>
</head>
<body>

<div class="welcome-section text-center mb-4">
    <h2 class="fw-bold">¡Bienvenido!</h2>
    <p class="mb-0 opacity-75">Panel de administración de Base de Datos</p>
</div>

<div class="container">
    <div class="row g-3">
        <div class="col-12">
            <a href="<?php echo e(route('backup.index')); ?>" class="text-decoration-none">
                <div class="card card-dash p-4 shadow-sm bg-white position-relative">
                    <i class="fas fa-server stat-icon text-success"></i>
                    <h6 class="text-muted small text-uppercase">Sistema</h6>
                    <h4 class="text-dark mb-1">Mantenimiento</h4>
                    <p class="text-muted small mb-0">Respaldos y restauración de SQL</p>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="<?php echo e(route('personas.index')); ?>" class="text-decoration-none">
                <div class="card card-dash p-3 shadow-sm bg-white">
                    <i class="fas fa-users text-primary mb-2" style="font-size: 1.5rem;"></i>
                    <h6 class="text-dark mb-1">Personas</h6>
                    <span class="badge bg-light text-primary p-0 text-start">Gestionar lista</span>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="<?php echo e(route('empleos.index')); ?>" class="text-decoration-none">
                <div class="card card-dash p-3 shadow-sm bg-white">
                    <i class="fas fa-briefcase text-dark mb-2" style="font-size: 1.5rem;"></i>
                    <h6 class="text-dark mb-1">Empleos</h6>
                    <span class="badge bg-light text-dark p-0 text-start">Gestionar puestos</span>
                </div>
            </a>
        </div>
        
        <div class="col-12 mt-4">
            <div class="card border-0 p-3 bg-light shadow-none">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <span class="spinner-grow spinner-grow-sm text-success"></span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block">Estado del Servidor</small>
                        <span class="fw-bold">Conectado a MySQL (WAMP)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="nav-mobile d-flex justify-content-around">
    <a href="<?php echo e(route('home')); ?>" class="nav-link-mobile <?php echo e(Route::is('home') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="<?php echo e(route('backup.index')); ?>" class="nav-link-mobile <?php echo e(Route::is('backup.index') ? 'active' : ''); ?>">
        <i class="fas fa-tools"></i> Mantenimiento
    </a>
    <a href="<?php echo e(route('personas.index')); ?>" class="nav-link-mobile <?php echo e(Route::is('personas.index') ? 'active' : ''); ?>">
        <i class="fas fa-users"></i> Personas
    </a>
    <a href="<?php echo e(route('empleos.index')); ?>" class="nav-link-mobile <?php echo e(Route::is('empleos.index') ? 'active' : ''); ?>">
        <i class="fas fa-briefcase"></i> Empleos
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\wamp64\www\mi-web\resources\views/home.blade.php ENDPATH**/ ?>