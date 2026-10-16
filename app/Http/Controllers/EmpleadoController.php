<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados,correo',
            'telefono' => 'required|string',
            'cargo' => 'required|string',
            'salario' => 'required|numeric|min:0',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|string',
        ]);

        $data = $request->all();

        // Enviar foto del empleado a la API externa de almacenamiento
        if ($request->hasFile('foto_file') && $request->file('foto_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('foto_file'));
            if ($apiUrl) {
                $data['foto'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['foto_file' => 'Error al subir la foto del empleado a la API externa.'])->withInput();
            }
        }

        Empleado::create($data);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:empleados,id',
        ]);

        $empleado = Empleado::findOrFail($request->input('id'));
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:empleados,id',
        ]);

        $empleado = Empleado::findOrFail($request->input('id'));
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:empleados,id',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados,correo,' . $id,
            'telefono' => 'required|string',
            'cargo' => 'required|string',
            'salario' => 'required|numeric|min:0',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|string',
        ]);

        $empleado = Empleado::findOrFail($id);
        $data = $request->all();

        // Enviar nueva foto a la API externa si fue seleccionada
        if ($request->hasFile('foto_file') && $request->file('foto_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('foto_file'));
            if ($apiUrl) {
                $data['foto'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['foto_file' => 'Error al actualizar la foto en la API externa.'])->withInput();
            }
        } elseif (empty($data['foto'])) {
            $data['foto'] = $empleado->foto;
        }

        $empleado->update($data);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:empleados,id',
        ]);

        try {
            $empleado = Empleado::findOrFail($request->input('id'));
            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('empleados.index')->with('error', 'No se puede eliminar este empleado porque tiene ventas o registros asociados.');
        }
    }
}
