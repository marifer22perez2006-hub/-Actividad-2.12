@extends('layouts.admin')

@section('titulo', 'Registrar Empleado - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-pink-600"></i>
            Registrar Nuevo Empleado
        </h1>
        <a href="{{ route('empleados.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nombres</label>
                <input type="text" name="nombres" value="{{ old('nombres') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Apellidos</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Cargo / Puesto</label>
                <select name="cargo" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
                    <option value="Repostero Principal">Repostero Principal</option>
                    <option value="Auxiliar de Cocina">Auxiliar de Cocina</option>
                    <option value="Cajero">Cajero</option>
                    <option value="Encargado de Tienda">Encargado de Tienda</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Salario Mensual ($)</label>
                <input type="number" step="0.01" name="salario" value="{{ old('salario', 0.00) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-3 border">
            </div>
        </div>

        <div class="p-4 bg-pink-50/50 rounded-2xl border border-pink-100 space-y-3">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fa-solid fa-camera text-pink-600 mr-1"></i> Foto de Perfil del Empleado
            </label>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Subir Foto desde la Computadora / Archivos</label>
                <input type="file" name="foto_file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 border rounded-xl p-2 bg-white">
                <p class="text-xs text-gray-400 mt-1">Soporta PNG, JPG, JPEG, WEBP (Máx. 2MB).</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">O URL de Imagen (Opcional)</label>
                <input type="url" name="foto" value="{{ old('foto') }}" placeholder="https://ejemplo.com/foto.jpg" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 p-2.5 border text-sm bg-white">
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t">
            <a href="{{ route('empleados.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Registrar Empleado
            </button>
        </div>
    </form>
</div>
@endsection
