@extends('layouts.admin')

@section('titulo', 'Editar Pedido - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
            Editar Pedido #{{ $pedido->id }}
        </h1>
        <a href="{{ route('pedidos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('pedidos.update') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="id" value="{{ $pedido->id }}">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Monto Total ($)</label>
            <input type="number" step="0.01" name="total" value="{{ old('total', $pedido->total) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Estado del Pedido</label>
            <select name="estado" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
                <option value="Completado" {{ $pedido->estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                <option value="Pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Cancelado" {{ $pedido->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('pedidos.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Pedido
            </button>
        </div>
    </form>
</div>
@endsection
