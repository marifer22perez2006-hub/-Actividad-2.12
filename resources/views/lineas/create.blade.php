@extends('layouts.admin')

@section('titulo', 'Crear Línea de Producto - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-list-check text-pink-600"></i>
            Registrar Línea de Producto
        </h1>
        <a href="{{ route('lineas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('lineas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de la Línea</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Línea Fría, Línea Gourmet, Sin Azúcar..." required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Subir Imagen desde la Computadora</label>
            <input type="file" name="imagen_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 border rounded-xl p-2 bg-gray-50">
            <p class="text-xs text-gray-400 mt-1">Soporta formatos PNG, JPG, JPEG, WEBP (Máx. 2MB).</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">O URL de Imagen Web (Opcional)</label>
            <input type="url" name="imagen" value="{{ old('imagen') }}" placeholder="https://ejemplo.com/linea.jpg" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            <p class="text-xs text-gray-400 mt-1">Puedes pegar la URL de una foto representativa.</p>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('lineas.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Línea
            </button>
        </div>
    </form>
</div>
@endsection
