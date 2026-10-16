@extends('layouts.admin')

@section('titulo', 'Detalle de Pedido - B&G Repostería')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-receipt text-pink-600"></i>
                Detalle del Pedido #PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
            </h1>
            <p class="text-xs text-gray-400 mt-0.5">Fecha: {{ \Carbon\Carbon::parse($pedido->fecha ?? $pedido->created_at)->format('d/m/Y H:i A') }}</p>
        </div>
        <a href="{{ route('pedidos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Pedidos
        </a>
    </div>

    <!-- Información del Pedido -->
    <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm">
        <div>
            <span class="text-xs font-bold text-gray-400 uppercase">Estado actual</span>
            <p class="font-bold text-gray-800 flex items-center gap-2 mt-0.5">
                <span class="inline-block w-2.5 h-2.5 rounded-full {{ $pedido->estado == 'Completado' ? 'bg-green-500' : ($pedido->estado == 'Pendiente' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                {{ $pedido->estado }}
            </p>
        </div>
        <div>
            <span class="text-xs font-bold text-gray-400 uppercase">Cambiar Estado</span>
            <form action="{{ route('pedidos.updateEstado') }}" method="POST" class="flex gap-2 mt-1">
                @csrf
                <input type="hidden" name="id" value="{{ $pedido->id }}">
                <select name="estado" class="text-xs rounded-lg border-gray-300 p-1.5 border font-semibold">
                    <option value="Completado" {{ $pedido->estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                    <option value="Pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Cancelado" {{ $pedido->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs px-3 py-1.5 rounded-lg font-bold">Cambiar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de Artículos -->
    <div class="mb-6 border rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Producto</th>
                    <th class="p-3 text-center">Cantidad</th>
                    <th class="p-3 text-right">Precio Unitario</th>
                    <th class="p-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pedido->detalles as $detalle)
                <tr>
                    <td class="p-3 font-medium text-gray-800">
                        {{ $detalle->producto->nombre ?? 'Producto #' . $detalle->producto_id }}
                    </td>
                    <td class="p-3 text-center font-bold text-gray-700">{{ $detalle->cantidad }}</td>
                    <td class="p-3 text-right text-gray-600">${{ number_format($detalle->precio, 2) }}</td>
                    <td class="p-3 text-right font-bold text-gray-900">${{ number_format($detalle->precio * $detalle->cantidad, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-400">Sin artículos especificados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Resumen de Costos -->
    <div class="bg-pink-50 p-6 rounded-2xl border border-pink-100 space-y-2 text-sm text-gray-700">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span class="font-semibold">${{ number_format($pedido->total - $pedido->iva, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>IVA (16%):</span>
            <span class="font-semibold">${{ number_format($pedido->iva, 2) }}</span>
        </div>
        <div class="flex justify-between text-xl font-extrabold text-pink-900 border-t border-pink-200 pt-3">
            <span>Total Cobrado:</span>
            <span>${{ number_format($pedido->total, 2) }}</span>
        </div>
    </div>

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ route('pedidos.edit', ['id' => $pedido->id]) }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fa-solid fa-pen"></i> Editar Pedido
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 bg-gray-800 text-white rounded-xl font-bold hover:bg-gray-900 shadow transition flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Imprimir Recibo
        </button>
    </div>
</div>
@endsection
