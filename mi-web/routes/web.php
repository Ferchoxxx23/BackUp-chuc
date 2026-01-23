<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirigir la raíz al centro de mantenimiento
Route::get('/', [BackupController::class, 'viewHome'])->name('home');

// --- VISTAS PRINCIPALES (Navegación Menú Móvil) ---

// 1. Centro de Mantenimiento (Respaldos y Restauración)
Route::get('/mantenimiento', [BackupController::class, 'index'])->name('backup.index');

// 2. Vista exclusiva de Personas
Route::get('/personas', [BackupController::class, 'viewPersonas'])->name('personas.index');

// 3. Vista exclusiva de Empleos
Route::get('/empleos', [BackupController::class, 'viewEmpleos'])->name('empleos.index');


// --- ACCIONES DE DATOS Y SISTEMA ---

// Procesar la creación del respaldo .sql
Route::post('/backup/create', [BackupController::class, 'createBackup'])->name('backup.create');

// Procesar la restauración de la base de datos
Route::post('/backup/restore', [BackupController::class, 'restoreBackup'])->name('backup.restore');

// Insertar datos (usado por los modales en Personas y Empleos)
Route::post('/backup/insert', [BackupController::class, 'insertData'])->name('backup.insert');

Route::delete('/personas/{id}', [BackupController::class, 'destroyPersona'])->name('personas.destroy');
Route::put('/personas/{id}', [BackupController::class, 'updatePersona'])->name('personas.update');

Route::put('/empleos/{id}', [BackupController::class, 'updateEmpleo'])->name('empleos.update');
Route::delete('/empleos/{id}', [BackupController::class, 'destroyEmpleo'])->name('empleos.destroy');
Route::post('/empleos/store', [BackupController::class, 'storeEmpleo'])->name('empleos.store');