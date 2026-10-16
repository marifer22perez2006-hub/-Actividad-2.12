<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index()
    {
        $lineas = Linea::all();
        return view('lineas.index', compact('lineas'));
    }

    public function create()
    {
        return view('lineas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:lineas,nombre|max:255',
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
            $data['imagen'] = 'https://images.unsplash.com/photo-1557089706-6fd900483863?w=500';
        }

        Linea::create($data);

        return redirect()->route('lineas.index')->with('success', 'Línea creada correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:lineas,id',
        ]);

        $linea = Linea::findOrFail($request->input('id'));
        return view('lineas.show', compact('linea'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:lineas,id',
        ]);

        $linea = Linea::findOrFail($request->input('id'));
        return view('lineas.edit', compact('linea'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:lineas,id',
            'nombre' => 'required|max:255|unique:lineas,nombre,' . $id,
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen' => 'nullable|string',
        ]);

        $linea = Linea::findOrFail($id);
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
            $data['imagen'] = $linea->imagen;
        }

        $linea->update($data);

        return redirect()->route('lineas.index')->with('success', 'Línea actualizada correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:lineas,id',
        ]);

        try {
            $linea = Linea::findOrFail($request->input('id'));
            $linea->delete();
            return redirect()->route('lineas.index')->with('success', 'Línea eliminada.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('lineas.index')->with('error', 'No se puede eliminar esta línea porque tiene productos asociados.');
        }
    }
}
