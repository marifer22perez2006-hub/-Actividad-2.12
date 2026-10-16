@extends('layouts.admin')

@section('titulo', 'Estado de Caja POS - B&G Repostería')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-cash-register text-pink-600"></i>
            Estado de Sesión en Caja
        </h1>
        <a href="{{ route('pos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Ir al POS
        </a>
    </div>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-xl border">
            <span class="text-xs font-bold text-gray-400 uppercase">Estado</span>
            <p class="text-lg font-bold text-green-600">Caja Abierta & Activa</p>
        </div>
        <a href="{{ route('pos.index') }}" class="inline-block px-5 py-2.5 bg-pink-600 text-white rounded-xl font-bold">Ir al Terminal de Ventas</a>
    </div>
</div>
@endsection
