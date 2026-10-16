<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tipo;
use App\Models\Marca;
use App\Models\Linea;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['tipo', 'marca', 'linea'])->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $tipos = Tipo::all();
        $marcas = Marca::all();
        $lineas = Linea::all();
        return view('productos.create', compact('tipos', 'marcas', 'lineas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_id' => 'required|exists:tipos,id',
            'marca_id' => 'required|exists:marcas,id',
            'linea_id' => 'required|exists:lineas,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'existencia' => 'required|integer|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'imagen1_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen1' => 'nullable|string',
            'imagen2_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen2' => 'nullable|string',
            'imagen3_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen3' => 'nullable|string',
        ]);

        $data = $request->all();

        // Enviar imagen principal a la API externa de almacenamiento
        if ($request->hasFile('imagen1_file') && $request->file('imagen1_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen1_file'));
            if ($apiUrl) {
                $data['imagen1'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['imagen1_file' => 'No se pudo subir la imagen a la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen1'])) {
            $data['imagen1'] = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500';
        }

        if ($request->hasFile('imagen2_file') && $request->file('imagen2_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen2_file'));
            if ($apiUrl) {
                $data['imagen2'] = $apiUrl;
            }
        }

        if ($request->hasFile('imagen3_file') && $request->file('imagen3_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen3_file'));
            if ($apiUrl) {
                $data['imagen3'] = $apiUrl;
            }
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:productos,id',
        ]);

        $producto = Producto::with(['tipo', 'marca', 'linea'])->findOrFail($request->input('id'));
        return view('productos.show', compact('producto'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:productos,id',
        ]);

        $producto = Producto::findOrFail($request->input('id'));
        $tipos = Tipo::all();
        $marcas = Marca::all();
        $lineas = Linea::all();
        return view('productos.edit', compact('producto', 'tipos', 'marcas', 'lineas'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:productos,id',
            'tipo_id' => 'required|exists:tipos,id',
            'marca_id' => 'required|exists:marcas,id',
            'linea_id' => 'required|exists:lineas,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'existencia' => 'required|integer|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'imagen1_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen1' => 'nullable|string',
            'imagen2_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen2' => 'nullable|string',
            'imagen3_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagen3' => 'nullable|string',
        ]);

        $producto = Producto::findOrFail($id);
        $data = $request->all();

        // Enviar nueva imagen a la API externa si se selecciona un archivo
        if ($request->hasFile('imagen1_file') && $request->file('imagen1_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen1_file'));
            if ($apiUrl) {
                $data['imagen1'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['imagen1_file' => 'No se pudo actualizar la imagen en la API externa.'])->withInput();
            }
        } elseif (empty($data['imagen1'])) {
            $data['imagen1'] = $producto->imagen1;
        }

        if ($request->hasFile('imagen2_file') && $request->file('imagen2_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen2_file'));
            if ($apiUrl) {
                $data['imagen2'] = $apiUrl;
            }
        } elseif (empty($data['imagen2'])) {
            $data['imagen2'] = $producto->imagen2;
        }

        if ($request->hasFile('imagen3_file') && $request->file('imagen3_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('imagen3_file'));
            if ($apiUrl) {
                $data['imagen3'] = $apiUrl;
            }
        } elseif (empty($data['imagen3'])) {
            $data['imagen3'] = $producto->imagen3;
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:productos,id',
        ]);

        try {
            $producto = Producto::findOrFail($request->input('id'));
            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('productos.index')->with('error', 'No se puede eliminar este producto porque está asociado a ventas o pedidos existentes.');
        }
    }
}
