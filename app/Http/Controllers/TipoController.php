<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::all();
        return view('tipos.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tipos,nombre|max:255',
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen' => 'nullable|string',
        ]);

        $data = $request->all();

        // Enviar imagen a la API externa de almacenamiento
        if ($request->hasFile('imagen_file') && $request->file('imagen_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen_file'));
            if ($apiUrl) {
                $data['imagen'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['imagen_file' => 'Error al subir la imagen a la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen'])) {
            $data['imagen'] = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500';
        }

        Tipo::create($data);

        return redirect()->route('tipos.index')->with('success', 'Tipo creado correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tipos,id',
        ]);

        $tipo = Tipo::findOrFail($request->input('id'));
        return view('tipos.show', compact('tipo'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tipos,id',
        ]);

        $tipo = Tipo::findOrFail($request->input('id'));
        return view('tipos.edit', compact('tipo'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:tipos,id',
            'nombre' => 'required|max:255|unique:tipos,nombre,' . $id,
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen' => 'nullable|string',
        ]);

        $tipo = Tipo::findOrFail($id);
        $data = $request->all();

        // Enviar nueva imagen a la API externa si fue seleccionada
        if ($request->hasFile('imagen_file') && $request->file('imagen_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen_file'));
            if ($apiUrl) {
                $data['imagen'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['imagen_file' => 'Error al actualizar la imagen en la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen'])) {
            $data['imagen'] = $tipo->imagen;
        }

        $tipo->update($data);

        return redirect()->route('tipos.index')->with('success', 'Tipo actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tipos,id',
        ]);

        try {
            $tipo = Tipo::findOrFail($request->input('id'));
            $tipo->delete();
            return redirect()->route('tipos.index')->with('success', 'Tipo eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('tipos.index')->with('error', 'No se puede eliminar este tipo porque tiene productos asociados.');
        }
    }
}
