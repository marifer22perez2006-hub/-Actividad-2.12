@extends('layouts.admin')

@section('titulo', 'Registrar Pedido - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-receipt text-pink-600"></i>
            Registrar Nuevo Pedido
        </h1>
        <a href="{{ route('pedidos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Monto Total ($)</label>
            <input type="number" step="0.01" name="total" value="{{ old('total') }}" placeholder="0.00" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">ID Cliente (Opcional)</label>
                <input type="number" name="cliente_id" value="{{ old('cliente_id', 1) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">ID Empleado (Opcional)</label>
                <input type="number" name="empleado_id" value="{{ old('empleado_id', 1) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('pedidos.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Pedido
            </button>
        </div>
    </form>
</div>
@endsection
