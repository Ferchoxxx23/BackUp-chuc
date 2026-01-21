<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personas - Gestión BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; padding-bottom: 80px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

        /* --- NAVEGACIÓN MÓVIL --- */
        .nav-mobile { 
            background: white; border-top: 1px solid #dee2e6; 
            position: fixed; bottom: 0; width: 100%; z-index: 1000; 
            display: flex; justify-content: space-around;
        }
        .nav-link-mobile { 
            text-align: center; font-size: 0.75rem; color: #6c757d; 
            text-decoration: none; padding: 10px 0; flex: 1; transition: all 0.3s ease; 
        }
        .nav-link-mobile i { display: block; font-size: 1.4rem; margin-bottom: 2px; transition: transform 0.3s ease; }
        .nav-link-mobile:hover i { transform: translateY(-5px); color: #0d6efd; }
        .nav-link-mobile.active { color: #0d6efd; font-weight: bold; }
        
        /* Botones de acción */
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; border: none; background: none; }
        .btn-edit { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; }
        .btn-edit:hover { background-color: #0d6efd; color: white; }
        .btn-delete { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .btn-delete:hover { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-users text-primary"></i> Personas</h4>
        <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPersona">
            <i class="fas fa-plus"></i> Nuevo
        </button>
    </div>

    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?php echo e(session('status')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Datos Personales</th>
                        <th>Ubicación</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="fw-bold"><?php echo e($p->Nombre); ?> <?php echo e($p->Apellido); ?></div>
                            <div class="small text-muted"><i class="fas fa-home me-1"></i> <?php echo e($p->Direccion); ?></div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i><?php echo e($p->Localidad); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($p->IdPersona); ?>" title="Editar">
                                    <i class="fas fa-edit small"></i>
                                </button>

                                <form action="<?php echo e(route('personas.destroy', $p->IdPersona)); ?>" method="POST" onsubmit="return confirm('¿Eliminar a <?php echo e($p->Nombre); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                        <i class="fas fa-trash-alt small"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="modal fade" id="editModal<?php echo e($p->IdPersona); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Editar Registro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?php echo e(route('personas.update', $p->IdPersona)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-body text-start">
                                                <div class="mb-2">
                                                    <label class="small fw-bold">Nombre</label>
                                                    <input type="text" name="Nombre" value="<?php echo e($p->Nombre); ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small fw-bold">Apellido</label>
                                                    <input type="text" name="Apellido" value="<?php echo e($p->Apellido); ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small fw-bold">Dirección</label>
                                                    <input type="text" name="Direccion" value="<?php echo e($p->Direccion); ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="small fw-bold">Localidad</label>
                                                    <input type="text" name="Localidad" value="<?php echo e($p->Localidad); ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary btn-sm px-4">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPersona" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('backup.insert')); ?>" method="POST">
                <?php echo csrf_field(); ?> 
                <input type="hidden" name="tabla" value="personas">
                <div class="modal-body">
                    <input type="text" name="Nombre" placeholder="Nombre" class="form-control mb-2" required>
                    <input type="text" name="Apellido" placeholder="Apellido" class="form-control mb-2" required>
                    <input type="text" name="Direccion" placeholder="Dirección" class="form-control mb-2" required>
                    <input type="text" name="Localidad" placeholder="Localidad" class="form-control mb-0" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="nav-mobile">
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
</html><?php /**PATH C:\wamp64\www\mi-web\resources\views/personas.blade.php ENDPATH**/ ?>