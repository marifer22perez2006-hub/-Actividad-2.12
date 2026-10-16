@extends('layouts.admin')

@section('titulo', 'Catálogo de Productos - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Catálogo de Productos</h1>
        <p class="text-sm text-gray-500">Listado general de artículos disponibles para la venta</p>
    </div>
    <a href="{{ route('productos.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Nuevo Producto
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-900 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4">Imagen</th>
                <th class="p-4">ID</th>
                <th class="p-4">Nombre</th>
                <th class="p-4">Tipo / Marca / Línea</th>
                <th class="p-4">Precio</th>
                <th class="p-4">Existencia</th>
                <th class="p-4">Estado</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($productos as $producto)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    @if($producto->imagen1)
                        <img src="{{ $producto->imagen1 }}" alt="{{ $producto->nombre }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200 shadow-sm">
                    @else
                        <div class="w-12 h-12 bg-pink-100 text-pink-500 rounded-lg flex items-center justify-center font-bold text-xs">
                            <i class="fa-solid fa-cake-candles text-lg"></i>
                        </div>
                    @endif
                </td>
                <td class="p-4 font-bold">#{{ $producto->id }}</td>
                <td class="p-4 font-bold text-gray-900">{{ $producto->nombre }}</td>
                <td class="p-4 text-xs">
                    <span class="block font-semibold text-gray-700">{{ $producto->tipo->nombre ?? 'N/A' }}</span>
                    <span class="text-gray-400">{{ $producto->marca->nombre ?? '' }} &bull; {{ $producto->linea->nombre ?? '' }}</span>
                </td>
                <td class="p-4 font-extrabold text-green-600">${{ number_format($producto->precio, 2) }}</td>
                <td class="p-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $producto->existencia > 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $producto->existencia }} uds.
                    </span>
                </td>
                <td class="p-4">
                    @if($producto->estado)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Activo</span>
                    @else
                        <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full font-medium">Inactivo</span>
                    @endif
                </td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('productos.show', ['id' => $producto->id]) }}" class="text-gray-600 hover:text-gray-800" title="Ver detalle">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('productos.edit', ['id' => $producto->id]) }}" class="text-blue-600 hover:text-blue-800" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('productos.destroy') }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $producto->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center p-12 text-gray-400">
                    <i class="fa-solid fa-cookie-bite text-4xl mb-2 text-pink-200"></i>
                    <p class="text-gray-500 font-medium">No hay productos registrados aún en el catálogo.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
