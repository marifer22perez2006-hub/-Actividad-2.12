<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:marcas,nombre|max:255',
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
                return redirect()->back()->withErrors(['imagen_file' => 'Error al subir el logo a la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen'])) {
            $data['imagen'] = 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?w=500';
        }

        Marca::create($data);

        return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:marcas,id',
        ]);

        $marca = Marca::findOrFail($request->input('id'));
        return view('marcas.show', compact('marca'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:marcas,id',
        ]);

        $marca = Marca::findOrFail($request->input('id'));
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:marcas,id',
            'nombre' => 'required|max:255|unique:marcas,nombre,' . $id,
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen' => 'nullable|string',
        ]);

        $marca = Marca::findOrFail($id);
        $data = $request->all();

        // Enviar nueva imagen a la API externa si fue seleccionada
        if ($request->hasFile('imagen_file') && $request->file('imagen_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen_file'));
            if ($apiUrl) {
                $data['imagen'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['imagen_file' => 'Error al actualizar el logo en la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen'])) {
            $data['imagen'] = $marca->imagen;
        }

        $marca->update($data);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:marcas,id',
        ]);

        try {
            $marca = Marca::findOrFail($request->input('id'));
            $marca->delete();
            return redirect()->route('marcas.index')->with('success', 'Marca eliminada.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('marcas.index')->with('error', 'No se puede eliminar esta marca porque tiene productos asociados.');
        }
    }
}
