@extends('layouts.admin')

@section('titulo', 'Editar Cliente - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-blue-600"></i>
            Editar Cliente #{{ $cliente->id }}
        </h1>
        <a href="{{ route('clientes.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('clientes.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="id" value="{{ $cliente->id }}">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo / Empresa</label>
            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Dirección de Entrega / Domicilio</label>
            <textarea name="direccion" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">{{ old('direccion', $cliente->direccion) }}</textarea>
        </div>

        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-3">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fa-solid fa-camera text-blue-600 mr-1"></i> Foto del Cliente / Logotipo
            </label>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Subir Nueva Foto desde la Computadora</label>
                <input type="file" name="foto_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 border rounded-xl p-2 bg-white">
                <p class="text-xs text-gray-400 mt-1">Sube una nueva foto si deseas cambiar la actual.</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">O URL de Imagen Web</label>
                <input type="url" name="foto" value="{{ old('foto', $cliente->foto) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-2.5 border text-sm bg-white">
            </div>
            @if($cliente->foto)
                <div class="mt-3 flex items-center gap-3 bg-white p-3 rounded-xl border border-blue-100">
                    <img src="{{ $cliente->foto }}" alt="{{ $cliente->nombre }}" class="w-16 h-16 object-cover rounded-full border">
                    <span class="text-xs text-gray-500">Vista previa de la foto actual</span>
                </div>
            @endif
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('clientes.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Cliente
            </button>
        </div>
    </form>
</div>
@endsection
