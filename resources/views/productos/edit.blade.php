@extends('layouts.admin')

@section('titulo', 'Editar Producto - B&G Repostería')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
            Editar Producto #{{ $producto->id }}
        </h1>
        <a href="{{ route('productos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('productos.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="id" value="{{ $producto->id }}">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Tipo de Postre</label>
                <select name="tipo_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border text-sm">
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_id', $producto->tipo_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Marca</label>
                <select name="marca_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border text-sm">
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca_id', $producto->marca_id) == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Línea</label>
                <select name="linea_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border text-sm">
                    @foreach($lineas as $linea)
                        <option value="{{ $linea->id }}" {{ old('linea_id', $producto->linea_id) == $linea->id ? 'selected' : '' }}>{{ $linea->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre del Producto</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" rows="3" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Precio ($)</label>
                <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Existencia (Stock)</label>
                <input type="number" name="existencia" value="{{ old('existencia', $producto->existencia) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Descuento ($)</label>
                <input type="number" step="0.01" name="descuento" value="{{ old('descuento', $producto->descuento) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <!-- Carga de Imagen Principal -->
        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-3">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fa-solid fa-image text-blue-600 mr-1"></i> Imagen Principal del Producto
            </label>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Subir Nueva Imagen desde la Computadora</label>
                <input type="file" name="imagen1_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 border rounded-xl p-2 bg-white">
                <p class="text-xs text-gray-400 mt-1">Sube una nueva foto si deseas reemplazar la actual.</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">O URL de Imagen Web</label>
                <input type="url" name="imagen1" value="{{ old('imagen1', $producto->imagen1) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-2.5 border text-sm bg-white">
            </div>
            @if($producto->imagen1)
                <div class="mt-3 flex items-center gap-3 bg-white p-3 rounded-xl border border-blue-100">
                    <img src="{{ $producto->imagen1 }}" alt="{{ $producto->nombre }}" class="w-16 h-16 object-cover rounded-lg border">
                    <span class="text-xs text-gray-500">Vista previa de la imagen actual</span>
                </div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Estado</label>
            <select name="estado" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
                <option value="1" {{ $producto->estado == 1 ? 'selected' : '' }}>Activo para venta</option>
                <option value="0" {{ $producto->estado == 0 ? 'selected' : '' }}>Inactivo / Deshabilitado</option>
            </select>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('productos.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Producto
            </button>
        </div>
    </form>
</div>
@endsection
