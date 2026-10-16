@extends('layouts.admin')

@section('titulo', 'Inventario de Insumos - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Inventario de Insumos</h1>
        <p class="text-sm text-gray-500">Materia prima y materiales de repostería</p>
    </div>
    <a href="{{ route('insumos.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Registrar Insumo
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-900 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4">Imagen</th>
                <th class="p-4">ID</th>
                <th class="p-4">Insumo</th>
                <th class="p-4">Unidad de Medida</th>
                <th class="p-4">Stock Disponible</th>
                <th class="p-4">Costo p/Unidad</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($insumos as $insumo)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    @if($insumo->imagen)
                        <img src="{{ $insumo->imagen }}" alt="{{ $insumo->nombre }}" class="w-10 h-10 object-cover rounded-lg border border-gray-200 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    @endif
                </td>
                <td class="p-4 font-bold">#{{ $insumo->id }}</td>
                <td class="p-4 font-bold text-gray-800">{{ $insumo->nombre }}</td>
                <td class="p-4 text-xs font-semibold uppercase text-gray-600">{{ $insumo->unidad_medida }}</td>
                <td class="p-4">
                    <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $insumo->cantidad_stock > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $insumo->cantidad_stock }} {{ $insumo->unidad_medida }}
                    </span>
                </td>
                <td class="p-4 font-semibold text-gray-900">${{ number_format($insumo->precio_unidad, 2) }}</td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('insumos.show', ['id' => $insumo->id]) }}" class="text-gray-600 hover:text-gray-800" title="Ver detalle">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('insumos.edit', ['id' => $insumo->id]) }}" class="text-blue-600 hover:text-blue-800" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('insumos.destroy') }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar insumo?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $insumo->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-12 text-gray-400">
                    <i class="fa-solid fa-boxes-stacked text-4xl mb-2 text-pink-200"></i>
                    <p class="text-gray-500 font-medium">No hay insumos en el inventario.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
