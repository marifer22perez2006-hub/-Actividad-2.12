<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::all();
        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'unidad_medida' => 'required|string|max:50',
            'cantidad_stock' => 'required|numeric|min:0',
            'precio_unidad' => 'required|numeric|min:0',
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
        }

        Insumo::create($data);

        return redirect()->route('insumos.index')->with('success', 'Insumo registrado correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:insumos,id',
        ]);

        $insumo = Insumo::findOrFail($request->input('id'));
        return view('insumos.show', compact('insumo'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:insumos,id',
        ]);

        $insumo = Insumo::findOrFail($request->input('id'));
        return view('insumos.edit', compact('insumo'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:insumos,id',
            'nombre' => 'required|string|max:255',
            'unidad_medida' => 'required|string|max:50',
            'cantidad_stock' => 'required|numeric|min:0',
            'precio_unidad' => 'required|numeric|min:0',
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen' => 'nullable|string',
        ]);

        $insumo = Insumo::findOrFail($id);
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
            $data['imagen'] = $insumo->imagen;
        }

        $insumo->update($data);

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:insumos,id',
        ]);

        try {
            $insumo = Insumo::findOrFail($request->input('id'));
            $insumo->delete();
            return redirect()->route('insumos.index')->with('success', 'Insumo eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('insumos.index')->with('error', 'No se puede eliminar este insumo porque tiene registros asociados.');
        }
    }
}
