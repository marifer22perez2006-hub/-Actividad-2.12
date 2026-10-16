<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|string',
        ]);

        $data = $request->all();

        // Enviar foto del cliente a la API externa de almacenamiento
        if ($request->hasFile('foto_file') && $request->file('foto_file')->isValid()) {
            $apiUrl = ImageUploadService::upload($request->file('foto_file'));
            if ($apiUrl) {
                $data['foto'] = $apiUrl;
            } else {
                return redirect()->back()->withErrors(['foto_file' => 'Error al subir la foto del cliente a la API externa.'])->withInput();
            }
        }

        Cliente::create($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:clientes,id',
        ]);

        $cliente = Cliente::findOrFail($request->input('id'));
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:clientes,id',
        ]);

        $cliente = Cliente::findOrFail($request->input('id'));
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'id' => 'required|integer|exists:clientes,id',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|string',
        ]);

        $cliente = Cliente::findOrFail($id);
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
            $data['foto'] = $cliente->foto;
        }

        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:clientes,id',
        ]);

        try {
            $cliente = Cliente::findOrFail($request->input('id'));
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar este cliente porque tiene ventas o pedidos asociados.');
        }
    }
}
