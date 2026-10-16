<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['detalles.producto', 'cliente', 'empleado'])->orderBy('created_at', 'desc')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
        ]);

        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id ?? 1,
            'empleado_id' => $request->empleado_id ?? 1,
            'fecha' => now(),
            'iva' => $request->total * 0.16,
            'descuento' => 0,
            'total' => $request->total,
            'estado' => 'Completado',
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Request $request)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($request->input('id'));
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Request $request)
    {
        $pedido = Pedido::findOrFail($request->input('id'));
        return view('pedidos.edit', compact('pedido'));
    }

    public function updateEstado(Request $request)
    {
        $id = $request->input('id');
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado' => 'required|string'
        ]);

        $pedido->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado.');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado.');
    }

    public function destroy(Request $request)
    {
        $pedido = Pedido::findOrFail($request->input('id'));
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado.');
    }
}
