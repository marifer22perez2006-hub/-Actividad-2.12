@extends('layouts.admin')

@section('titulo', 'Editar Marca - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
            Editar Marca #{{ $marca->id }}
        </h1>
        <a href="{{ route('marcas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('marcas.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="id" value="{{ $marca->id }}">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de la Marca</label>
            <input type="text" name="nombre" value="{{ old('nombre', $marca->nombre) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Subir Nueva Imagen desde la Computadora</label>
            <input type="file" name="imagen_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border rounded-xl p-2 bg-gray-50">
            <p class="text-xs text-gray-400 mt-1">Sube un nuevo logo o imagen si deseas cambiar el actual.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">O URL de la Imagen / Logo Web</label>
            <input type="url" name="imagen" value="{{ old('imagen', $marca->imagen) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            @if($marca->imagen)
                <div class="mt-3 flex items-center gap-3 bg-gray-50 p-3 rounded-lg border">
                    <img src="{{ $marca->imagen }}" alt="{{ $marca->nombre }}" class="w-16 h-16 object-cover rounded-lg border">
                    <span class="text-xs text-gray-500">Vista previa del logo actual</span>
                </div>
            @endif
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('marcas.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Marca
            </button>
        </div>
    </form>
</div>
@endsection
