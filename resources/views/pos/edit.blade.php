@extends('layouts.admin')

@section('titulo', 'Ajustes de POS - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-sliders text-blue-600"></i>
            Configuración de Punto de Venta
        </h1>
        <a href="{{ route('pos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Ir al POS
        </a>
    </div>

    <div class="space-y-4">
        <p class="text-gray-600">Ajuste de parámetros del punto de venta y terminales de cobro.</p>
        <a href="{{ route('pos.index') }}" class="inline-block px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold">Volver a la Caja</a>
    </div>
</div>
@endsection
