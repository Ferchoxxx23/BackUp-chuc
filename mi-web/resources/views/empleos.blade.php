<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos - Gestión BD</title>
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
        <h4><i class="fas fa-briefcase text-primary"></i> Empleos</h4>
        <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoEmpleo">
            <i class="fas fa-plus"></i> Nuevo
        </button>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding: 0.75rem;"></button>
        </div>
    @endif

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Descripción</th>
                        <th>Turno</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleos as $e)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $e->Descripcion }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="far fa-clock text-primary me-1"></i> {{ $e->Turno }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $e->IdEmpleo }}" title="Editar">
                                    <i class="fas fa-edit small"></i>
                                </button>

                                <form action="{{ route('empleos.destroy', $e->IdEmpleo) }}" method="POST" onsubmit="return confirm('¿Eliminar {{ $e->Descripcion }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                        <i class="fas fa-trash-alt small"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="modal fade" id="editModal{{ $e->IdEmpleo }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Editar Empleo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('empleos.update', $e->IdEmpleo) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="small fw-bold">Descripción</label>
                                                    <input type="text" name="Descripcion" value="{{ $e->Descripcion }}" class="form-control" placeholder="Ej: Gerente" required>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="small fw-bold">Turno</label>
                                                    <input type="text" name="Turno" value="{{ $e->Turno }}" class="form-control" placeholder="Ingrese su turno" required>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoEmpleo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Empleo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('empleos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small fw-bold mb-1 d-block text-start">Puesto</label>
                        <input type="text" name="Descripcion" placeholder="Descripción del puesto" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold mb-1 d-block text-start">Turno</label>
                        <input type="text" name="Turno" placeholder="Ingrese su turno" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Guardar Registro</button>
                </div>
            </form>
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