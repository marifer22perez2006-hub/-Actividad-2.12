@extends('layouts.admin')

@section('titulo', 'Gestión de Clientes - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Clientes</h1>
        <p class="text-sm text-gray-500">Base de datos de clientes registrados</p>
    </div>
    <a href="{{ route('clientes.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
        <i class="fa-solid fa-user-plus"></i> Registrar Cliente
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-900 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4">Foto</th>
                <th class="p-4">ID</th>
                <th class="p-4">Nombre / Razón Social</th>
                <th class="p-4">Correo Electrónico</th>
                <th class="p-4">Teléfono</th>
                <th class="p-4">Dirección</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($clientes as $cliente)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    @if($cliente->foto)
                        <img src="{{ $cliente->foto }}" alt="{{ $cliente->nombre }}" class="w-10 h-10 object-cover rounded-full border border-gray-200 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">
                            <i class="fa-solid fa-user-tag"></i>
                        </div>
                    @endif
                </td>
                <td class="p-4 font-bold">#{{ $cliente->id }}</td>
                <td class="p-4 font-bold text-gray-900">
                    {{ $cliente->nombre }}
                </td>
                <td class="p-4 text-gray-600">{{ $cliente->correo ?? 'N/A' }}</td>
                <td class="p-4 text-gray-600">{{ $cliente->telefono ?? 'N/A' }}</td>
                <td class="p-4 text-gray-600">{{ $cliente->direccion ?? 'Sin dirección' }}</td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('clientes.show', ['id' => $cliente->id]) }}" class="text-gray-600 hover:text-gray-800" title="Ver detalle">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('clientes.edit', ['id' => $cliente->id]) }}" class="text-blue-600 hover:text-blue-800 font-semibold" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('clientes.destroy') }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar a este cliente?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $cliente->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-12 text-gray-400">
                    <i class="fa-solid fa-users text-4xl mb-2 text-pink-200"></i>
                    <p class="text-gray-500 font-medium">No hay clientes registrados.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
