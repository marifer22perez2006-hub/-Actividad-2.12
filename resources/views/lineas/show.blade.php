@extends('layouts.admin')

@section('titulo', 'Detalle de Línea - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-list-check text-pink-600"></i>
            Detalle de Línea #{{ $linea->id }}
        </h1>
        <a href="{{ route('lineas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex justify-center bg-gray-50 p-4 rounded-xl border">
            @if($linea->imagen)
                <img src="{{ $linea->imagen }}" alt="{{ $linea->nombre }}" class="max-h-56 object-cover rounded-lg shadow-sm">
            @else
                <i class="fa-solid fa-list-check text-5xl text-pink-300"></i>
            @endif
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <span class="text-xs font-bold text-gray-400 uppercase">Nombre de la Línea</span>
            <p class="text-lg font-bold text-gray-800">{{ $linea->nombre }}</p>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t flex justify-end gap-3">
        <a href="{{ route('lineas.edit', ['id' => $linea->id]) }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
            <i class="fa-solid fa-pen mr-1"></i> Editar Línea
        </a>
    </div>
</div>
@endsection
