@extends('layouts.admin')

@section('titulo', 'Historial de Pedidos y Ventas - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Pedidos y Ventas</h1>
        <p class="text-sm text-gray-500">Historial de transacciones procesadas en el Punto de Venta</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('pedidos.create') }}" class="bg-pink-800 hover:bg-pink-900 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Pedido
        </a>
        <a href="{{ route('pos.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-cash-register"></i> Ir al POS
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-900 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4">Folio</th>
                <th class="p-4">Cliente</th>
                <th class="p-4">Atendido Por</th>
                <th class="p-4">Fecha / Hora</th>
                <th class="p-4">Artículos</th>
                <th class="p-4">Total</th>
                <th class="p-4">Estado</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($pedidos as $pedido)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-bold text-pink-700">#PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="p-4 font-semibold text-gray-900">
                    {{ $pedido->cliente->nombre ?? 'Cliente Mostrador' }}
                </td>
                <td class="p-4 text-gray-600">
                    {{ $pedido->empleado ? ($pedido->empleado->nombres . ' ' . $pedido->empleado->apellidos) : 'Cajero General' }}
                </td>
                <td class="p-4 text-xs font-medium text-gray-600">{{ \Carbon\Carbon::parse($pedido->fecha ?? $pedido->created_at)->format('d/m/Y H:i A') }}</td>
                <td class="p-4 font-medium">
                    <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-lg text-xs font-bold">
                        {{ $pedido->detalles ? $pedido->detalles->sum('cantidad') : 0 }} items
                    </span>
                </td>
                <td class="p-4 font-extrabold text-green-600 text-base">${{ number_format($pedido->total, 2) }}</td>
                <td class="p-4">
                    @if($pedido->estado == 'Completado')
                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-bold">Completado</span>
                    @elseif($pedido->estado == 'Pendiente')
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded-full font-bold">Pendiente</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-bold">{{ $pedido->estado }}</span>
                    @endif
                </td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('pedidos.show', ['id' => $pedido->id]) }}" class="inline-flex items-center gap-1 text-pink-600 hover:text-pink-800 font-bold bg-pink-50 hover:bg-pink-100 px-3 py-1.5 rounded-lg transition text-xs" title="Ver Recibo">
                        <i class="fa-solid fa-eye"></i> Recibo
                    </a>
                    <a href="{{ route('pedidos.edit', ['id' => $pedido->id]) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition text-xs" title="Editar">
                        <i class="fa-solid fa-pen"></i> Editar
                    </a>
                    <form action="{{ route('pedidos.destroy') }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este pedido?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $pedido->id }}">
                        <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition text-xs" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center p-12 text-gray-400">
                    <i class="fa-solid fa-receipt text-4xl mb-2 text-pink-200"></i>
                    <p class="text-gray-500 font-medium">No hay ventas registradas aún.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
