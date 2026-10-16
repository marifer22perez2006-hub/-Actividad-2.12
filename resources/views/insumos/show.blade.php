@extends('layouts.admin')

@section('titulo', 'Detalle de Insumo - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-boxes-stacked text-pink-600"></i>
            Detalle de Insumo #{{ $insumo->id }}
        </h1>
        <a href="{{ route('insumos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-xl border flex items-center gap-4">
            @if($insumo->imagen)
                <img src="{{ $insumo->imagen }}" alt="{{ $insumo->nombre }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shadow">
            @else
                <div class="w-16 h-16 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xl">
                    <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                </div>
            @endif
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Nombre del Insumo</span>
                <p class="text-lg font-bold text-gray-800">{{ $insumo->nombre }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-gray-50 p-4 rounded-xl border">
                <span class="text-xs font-bold text-gray-400 uppercase">Unidad</span>
                <p class="text-base font-bold text-gray-700 uppercase">{{ $insumo->unidad_medida }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border">
                <span class="text-xs font-bold text-gray-400 uppercase">Stock</span>
                <p class="text-base font-bold text-gray-900">{{ $insumo->cantidad_stock }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border">
                <span class="text-xs font-bold text-gray-400 uppercase">Precio Unitario</span>
                <p class="text-base font-bold text-green-600">${{ number_format($insumo->precio_unidad, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t flex justify-end gap-3">
        <a href="{{ route('insumos.edit', ['id' => $insumo->id]) }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
            <i class="fa-solid fa-pen mr-1"></i> Editar Insumo
        </a>
    </div>
</div>
@endsection
