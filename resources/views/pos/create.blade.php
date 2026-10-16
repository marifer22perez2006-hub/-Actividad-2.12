@extends('layouts.admin')

@section('titulo', 'Crear Nueva Sesión POS - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-cash-register text-pink-600"></i>
            Apertura de Caja (POS)
        </h1>
        <a href="{{ route('pos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Ir al POS
        </a>
    </div>

    <form action="{{ route('pos.index') }}" method="GET" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Monto Inicial en Caja ($)</label>
            <input type="number" step="0.01" name="monto_inicial" value="500.00" required class="w-full rounded-xl border-gray-300 p-3 border">
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('pos.index') }}" class="px-5 py-2.5 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow">
                Abrir Caja y Comenzar
            </a>
        </div>
    </form>
</div>
@endsection
