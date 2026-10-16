@extends('layouts.admin')

@section('titulo', 'Detalle de Cliente - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-tag text-pink-600"></i>
            Detalle del Cliente #{{ $cliente->id }}
        </h1>
        <a href="{{ route('clientes.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-xl border flex items-center gap-4">
            @if($cliente->foto)
                <img src="{{ $cliente->foto }}" alt="{{ $cliente->nombre }}" class="w-16 h-16 rounded-full object-cover border-2 border-pink-200 shadow">
            @else
                <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xl">
                    <i class="fa-solid fa-user-tag text-2xl"></i>
                </div>
            @endif
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Nombre Completo / Razón Social</span>
                <p class="text-lg font-bold text-gray-800">{{ $cliente->nombre }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-xl border">
                <span class="text-xs font-bold text-gray-400 uppercase">Correo Electrónico</span>
                <p class="text-base font-bold text-gray-700">{{ $cliente->correo ?? 'No registrado' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border">
                <span class="text-xs font-bold text-gray-400 uppercase">Teléfono</span>
                <p class="text-base font-bold text-gray-700">{{ $cliente->telefono ?? 'No registrado' }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl border">
            <span class="text-xs font-bold text-gray-400 uppercase">Dirección de Entrega</span>
            <p class="text-base font-bold text-gray-800">{{ $cliente->direccion ?? 'Sin dirección registrada' }}</p>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t flex justify-end gap-3">
        <a href="{{ route('clientes.edit', ['id' => $cliente->id]) }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fa-solid fa-pen"></i> Editar Cliente
        </a>
    </div>
</div>
@endsection
