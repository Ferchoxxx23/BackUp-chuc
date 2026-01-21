<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Empleo;

date_default_timezone_set('America/Mexico_City');

class BackupController extends Controller
{
    /**
     * Vista de Mantenimiento (Inicio)
     */
    public function index()
    {
        return view('mantenimiento');
    }
    public function viewHome()
{
    return view('home');
    }

    public function viewPersonas()
    {
        $personas = Persona::all();
        return view('personas', compact('personas'));
    }

    /**
     * Vista exclusiva de Empleos
     */
    public function viewEmpleos()
    {
        $empleos = Empleo::all();
        return view('empleos', compact('empleos'));
    }

    /**
     * Proceso de creación de respaldo SQL
     */
    public function createBackup()
    {
        $filename = "Respaldo_" . date('Y-m-d_H-i-s') . ".sql";
        $path = storage_path("app/backups");

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

        $command = sprintf(
            'mysqldump --opt --routines --triggers -h %s -u %s %s %s > "%s"',
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD') ? '-p' . env('DB_PASSWORD') : '',
            env('DB_DATABASE'),
            $fullPath
        );

        exec($command, $output, $returnVar);

        return ($returnVar === 0) 
            ? back()->with('status', "Respaldo generado: $filename") 
            : back()->with('status', 'Error al crear el respaldo.');
    }

    /**
     * Proceso de restauración de base de datos
     */
    public function restoreBackup(Request $request)
    {
        $request->validate(['backup_file' => 'required']);
        $file = $request->file('backup_file');
        $filePath = $file->getRealPath();

        $dbHost = env('DB_HOST');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');
        $passwordFlag = $dbPass ? "-p$dbPass" : "";

        try {
            // Asegurar existencia de la base de datos
            $createCommand = "mysql -h $dbHost -u $dbUser $passwordFlag -e \"CREATE DATABASE IF NOT EXISTS $dbName\"";
            exec($createCommand);

            $restoreCommand = "mysql -h $dbHost -u $dbUser $passwordFlag $dbName < \"$filePath\"";
            exec($restoreCommand, $output, $returnVar);

            // Fallback para rutas específicas de WampServer
            if ($returnVar !== 0) {
                $mysqlPath = "C:\wamp64\bin\mysql\mysql8.4.7\bin\mysql.exe"; 
                $restoreCommand = "\"$mysqlPath\" -h $dbHost -u $dbUser $passwordFlag $dbName < \"$filePath\"";
                exec($restoreCommand, $output, $returnVar);
            }

            return back()->with('status', 'Base de datos restaurada correctamente.');
        } catch (\Exception $e) {
            return back()->with('status', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Inserción genérica de datos mediante Modelos
     */
    public function insertData(Request $request)
    {
        try {
            if ($request->tabla == 'personas') {
                Persona::create($request->except(['_token', 'tabla']));
            } else {
                Empleo::create($request->except(['_token', 'tabla']));
            }
            
            return back()->with('status', "Registro guardado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('status', "Error al insertar: " . $e->getMessage());
        }
    }
    public function destroyPersona($id)
    {
        try {
            $persona = Persona::findOrFail($id);
            $persona->delete();

            return back()->with('status', "Persona eliminada correctamente.");
        } catch (\Exception $e) {
            return back()->with('status', "Error al eliminar: " . $e->getMessage());
        }
    }
    public function updatePersona(Request $request, $id)
{
    try {
        $persona = Persona::findOrFail($id);
        $persona->update($request->all());

        return back()->with('status', "Registro de {$persona->Nombre} actualizado correctamente.");
    } catch (\Exception $e) {
        return back()->with('status', "Error al actualizar: " . $e->getMessage());
    }
}
    public function updateEmpleo(Request $request, $id)
    {
        $empleo = Empleo::findOrFail($id);
        $empleo->update($request->all());
        return back()->with('status', 'Empleo actualizado correctamente.');
    }

    public function destroyEmpleo($id)
    {
        $empleo = Empleo::findOrFail($id);
        $empleo->delete();
        return back()->with('status', 'Empleo eliminado correctamente.');
}
    public function storeEmpleo(Request $request)
    {
        try {
            $empleo = new Empleo();
            $empleo->Descripcion = $request->Descripcion;
            $empleo->Turno = $request->Turno;
            $empleo->save();

            return back()->with('status', 'Nuevo empleo guardado exitosamente.');
    } catch (\Exception $e) {
            return back()->with('status', 'Error al insertar: ' . $e->getMessage());
    }
}
    
}