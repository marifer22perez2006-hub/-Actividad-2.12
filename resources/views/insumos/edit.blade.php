@extends('layouts.admin')

@section('titulo', 'Editar Insumo - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
            Editar Insumo #{{ $insumo->id }}
        </h1>
        <a href="{{ route('insumos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('insumos.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="id" value="{{ $insumo->id }}">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre del Insumo</label>
            <input type="text" name="nombre" value="{{ old('nombre', $insumo->nombre) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Unidad de Medida</label>
                <select name="unidad_medida" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
                    <option value="kg" {{ $insumo->unidad_medida == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                    <option value="gramos" {{ $insumo->unidad_medida == 'gramos' ? 'selected' : '' }}>Gramos (g)</option>
                    <option value="litros" {{ $insumo->unidad_medida == 'litros' ? 'selected' : '' }}>Litros (L)</option>
                    <option value="ml" {{ $insumo->unidad_medida == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                    <option value="piezas" {{ $insumo->unidad_medida == 'piezas' ? 'selected' : '' }}>Piezas / Unidades</option>
                    <option value="cajas" {{ $insumo->unidad_medida == 'cajas' ? 'selected' : '' }}>Cajas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Stock Disponible</label>
                <input type="number" step="0.01" name="cantidad_stock" value="{{ old('cantidad_stock', $insumo->cantidad_stock) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Precio x Unidad ($)</label>
                <input type="number" step="0.01" name="precio_unidad" value="{{ old('precio_unidad', $insumo->precio_unidad) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-3">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fa-solid fa-image text-blue-600 mr-1"></i> Imagen del Insumo
            </label>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Subir Nueva Imagen desde la Computadora</label>
                <input type="file" name="imagen_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 border rounded-xl p-2 bg-white">
                <p class="text-xs text-gray-400 mt-1">Sube una nueva foto si deseas cambiar la actual.</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">O URL de Imagen Web</label>
                <input type="url" name="imagen" value="{{ old('imagen', $insumo->imagen) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-2.5 border text-sm bg-white">
            </div>
            @if($insumo->imagen)
                <div class="mt-3 flex items-center gap-3 bg-white p-3 rounded-xl border border-blue-100">
                    <img src="{{ $insumo->imagen }}" alt="{{ $insumo->nombre }}" class="w-16 h-16 object-cover rounded-lg border">
                    <span class="text-xs text-gray-500">Vista previa de la imagen actual</span>
                </div>
            @endif
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('insumos.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Insumo
            </button>
        </div>
    </form>
</div>
@endsection
