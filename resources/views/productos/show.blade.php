@extends('layouts.admin')

@section('titulo', 'Detalle de Producto - B&G Repostería')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-cookie-bite text-pink-600"></i>
            Detalle de Producto #{{ $producto->id }}
        </h1>
        <a href="{{ route('productos.index') }}" class="text-sm font-medium text-pink-600 hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Productos
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Imagen -->
        <div class="flex flex-col items-center justify-center bg-pink-50 p-6 rounded-2xl border border-pink-100">
            @if($producto->imagen1)
                <img src="{{ $producto->imagen1 }}" alt="{{ $producto->nombre }}" class="max-h-64 object-cover rounded-xl shadow-md border border-white">
            @else
                <div class="w-full h-48 bg-pink-100 text-pink-400 rounded-xl flex flex-col items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-cake-candles text-5xl mb-2"></i>
                    Sin imagen registrada
                </div>
            @endif
        </div>

        <!-- Detalles -->
        <div class="space-y-4 text-sm">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Nombre</span>
                <p class="text-xl font-bold text-gray-800">{{ $producto->nombre }}</p>
            </div>

            <div class="grid grid-cols-3 gap-2 bg-gray-50 p-3 rounded-xl border border-gray-100 text-xs">
                <div>
                    <span class="font-bold text-gray-400 block">Tipo:</span>
                    <span class="font-semibold text-gray-800">{{ $producto->tipo->nombre ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-bold text-gray-400 block">Marca:</span>
                    <span class="font-semibold text-gray-800">{{ $producto->marca->nombre ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-bold text-gray-400 block">Línea:</span>
                    <span class="font-semibold text-gray-800">{{ $producto->linea->nombre ?? 'N/A' }}</span>
                </div>
            </div>

            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Descripción</span>
                <p class="text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 mt-1">{{ $producto->descripcion }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase">Precio Unitario</span>
                    <p class="text-2xl font-extrabold text-green-600">${{ number_format($producto->precio, 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase">Existencias en Inventario</span>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $producto->existencia }} uds.</p>
                </div>
            </div>

            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-400 uppercase">Estado</span>
                @if($producto->estado)
                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold"><i class="fa-solid fa-check-circle mr-1"></i> Activo para Venta</span>
                @else
                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold"><i class="fa-solid fa-times-circle mr-1"></i> Inactivo</span>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-8 pt-4 border-t flex justify-end gap-3">
        <a href="{{ route('productos.edit', ['id' => $producto->id]) }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square"></i> Editar Producto
        </a>
    </div>
</div>
@endsection
