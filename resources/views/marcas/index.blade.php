@extends('layouts.admin')

@section('titulo', 'Marcas - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Marcas</h1>
        <p class="text-sm text-gray-500">Listado de marcas de insumos y productos</p>
    </div>
    <a href="{{ route('marcas.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Nueva Marca
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($marcas as $marca)
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 overflow-hidden flex flex-col justify-between transition">
        <div class="p-4">
            <div class="w-full h-36 bg-pink-50 rounded-lg overflow-hidden mb-3 flex items-center justify-center">
                @if($marca->imagen)
                    <img src="{{ $marca->imagen }}" alt="{{ $marca->nombre }}" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-tags text-4xl text-pink-300"></i>
                @endif
            </div>
            <h3 class="font-bold text-lg text-gray-800 text-center mb-1">{{ $marca->nombre }}</h3>
            <span class="text-xs text-gray-400 block text-center">ID: #{{ $marca->id }}</span>
        </div>
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100 flex justify-around text-xs font-semibold">
            <a href="{{ route('marcas.show', ['id' => $marca->id]) }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
                <i class="fa-solid fa-eye"></i> Ver
            </a>
            <a href="{{ route('marcas.edit', ['id' => $marca->id]) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <i class="fa-solid fa-pen"></i> Editar
            </a>
            <form action="{{ route('marcas.destroy') }}" method="POST" onsubmit="return confirm('¿Eliminar esta marca?')">
                @csrf
                <input type="hidden" name="id" value="{{ $marca->id }}">
                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                    <i class="fa-solid fa-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-xl p-12 text-center text-gray-400 shadow-sm border border-gray-200">
        <i class="fa-solid fa-tags text-5xl mb-3 text-pink-200"></i>
        <p class="text-lg font-medium text-gray-600">No hay marcas registradas.</p>
        <a href="{{ route('marcas.create') }}" class="mt-3 inline-block text-pink-600 hover:underline font-bold text-sm">Registrar la primera marca</a>
    </div>
    @endforelse
</div>
@endsection
