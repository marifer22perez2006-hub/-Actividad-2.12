@extends('layouts.admin')

@section('titulo', 'Gestión de Empleados - B&G Repostería')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Empleados</h1>
        <p class="text-sm text-gray-500">Personal de caja, repostería y administración</p>
    </div>
    <a href="{{ route('empleados.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
        <i class="fa-solid fa-user-plus"></i> Registrar Empleado
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-900 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4">Foto</th>
                <th class="p-4">ID</th>
                <th class="p-4">Empleado</th>
                <th class="p-4">Correo Electrónico</th>
                <th class="p-4">Teléfono</th>
                <th class="p-4">Cargo</th>
                <th class="p-4">Salario</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($empleados as $empleado)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    @if($empleado->foto)
                        <img src="{{ $empleado->foto }}" alt="{{ $empleado->nombres }}" class="w-10 h-10 object-cover rounded-full border border-gray-200 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                </td>
                <td class="p-4 font-bold">#{{ $empleado->id }}</td>
                <td class="p-4 font-bold text-gray-900">
                    {{ $empleado->nombres }} {{ $empleado->apellidos }}
                </td>
                <td class="p-4 text-gray-600">{{ $empleado->correo }}</td>
                <td class="p-4 text-gray-600">{{ $empleado->telefono }}</td>
                <td class="p-4">
                    <span class="bg-pink-50 text-pink-700 text-xs px-2.5 py-1 rounded-full font-bold">
                        {{ $empleado->cargo }}
                    </span>
                </td>
                <td class="p-4 font-semibold text-green-600">${{ number_format($empleado->salario, 2) }}</td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('empleados.show', ['id' => $empleado->id]) }}" class="text-gray-600 hover:text-gray-800" title="Ver detalle">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('empleados.edit', ['id' => $empleado->id]) }}" class="text-blue-600 hover:text-blue-800 font-semibold" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('empleados.destroy') }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar a este empleado?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $empleado->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center p-12 text-gray-400">
                    <i class="fa-solid fa-user-group text-4xl mb-2 text-pink-200"></i>
                    <p class="text-gray-500 font-medium">No hay empleados registrados en el sistema.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
