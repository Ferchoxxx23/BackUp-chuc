<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Empleo;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * PROCESO DE RESPALDO: Descarga el SQL directamente al navegador
     */
 public function createBackup()
{
    $filename = "Respaldo_" . date('Y-m-d_H-i-s') . ".sql";
    $content = "-- Respaldo generado automáticamente\n";
    $content .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n\n";
    $content .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

    $tables = ['persona', 'empleo']; 

    foreach ($tables as $table) {
        $res = DB::select("SHOW CREATE TABLE $table");
        $createTableSql = ((array)$res[0])['Create Table'];
        $content .= "DROP TABLE IF EXISTS `$table`;\n" . $createTableSql . ";\n\n";

        $rows = DB::table($table)->get();
        foreach ($rows as $row) {
            $rowArray = (array)$row;
            $columns = implode("`, `", array_keys($rowArray));
            $escapedValues = array_map(function($value) {
                if (is_null($value)) return "NULL";
                return "'" . addslashes($value) . "'";
            }, array_values($rowArray));

            $content .= "INSERT INTO `$table` (`$columns`) VALUES (" . implode(", ", $escapedValues) . ");\n";
        }
        $content .= "\n";
    }

    $content .= "SET FOREIGN_KEY_CHECKS=1;\n";

    // En lugar de StreamedResponse, usamos una respuesta normal con headers de descarga
    return response($content)
        ->header('Content-Type', 'application/sql')
        ->header('Content-Disposition', "attachment; filename=\"$filename\"")
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
}

    /**
     * PROCESO DE RESTAURACIÓN: Lee el archivo SQL subido y lo ejecuta
     */
    public function restoreBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file'
        ]);

        try {
            $file = $request->file('backup_file');
            $sql = file_get_contents($file->getRealPath());

            // Ejecuta el contenido del SQL directamente en la BD
            DB::unprepared($sql);

            return back()->with('status', 'Base de datos restaurada correctamente desde el archivo subido.');
        } catch (\Exception $e) {
            return back()->with('status', 'Error al restaurar: ' . $e->getMessage());
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

    /**
     * Gestión de Personas (Update/Delete)
     */
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

    /**
     * Gestión de Empleos (Store/Update/Delete)
     */
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
}