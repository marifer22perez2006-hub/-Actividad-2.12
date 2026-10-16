<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Punto de Venta | B&G Repostería</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans h-screen flex flex-col overflow-hidden">

    <!-- Header POS -->
    <header class="bg-pink-900 text-white px-6 py-3 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-cash-register text-2xl text-pink-300"></i>
            <h1 class="text-xl font-bold">Punto de Venta - B&G Repostería</h1>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm bg-pink-800 px-3 py-1 rounded-full flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-pink-300"></i> {{ Auth::guard('admin')->user()->nombre ?? 'Administrador' }}</span>
            <a href="{{ route('productos.index') }}" class="text-sm bg-pink-700 hover:bg-pink-600 px-3 py-1.5 rounded-lg transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Admin
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs bg-pink-800 hover:bg-pink-700 text-white font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                    <i class="fa-solid fa-right-from-bracket text-pink-300"></i> Salir
                </button>
            </form>
        </div>
    </header>

    <!-- Contenido Principal -->
    <div class="flex flex-1 overflow-hidden">

        <!-- Columna Izquierda: Catálogo de Productos -->
        <div class="w-3/5 p-6 flex flex-col overflow-y-auto border-r border-gray-200 bg-gray-50">
            <!-- Buscador -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="buscador" onkeyup="filtrarProductos()" placeholder="Buscar producto por nombre..." class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-4 text-gray-400"></i>
                </div>
            </div>

            <!-- Malla de Productos -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" id="grid-productos">
                @forelse($productos as $producto)
                <div onclick="agregarAlCarrito({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', {{ $producto->precio }}, {{ $producto->existencia }})"
                     class="tarjeta-producto bg-white p-4 rounded-xl shadow cursor-pointer hover:shadow-md hover:border-pink-500 border border-transparent transition flex flex-col justify-between"
                     data-nombre="{{ strtolower($producto->nombre) }}">
                    <div>
                        <div class="text-xs text-pink-600 font-bold uppercase mb-1">{{ $producto->tipo->nombre ?? 'Postre' }}</div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1 leading-snug">{{ $producto->nombre }}</h3>
                        <p class="text-xs text-gray-500">Stock: <span id="stock-{{ $producto->id }}">{{ $producto->existencia }}</span></p>
                    </div>
                    <div class="mt-3 flex justify-between items-center pt-2 border-t border-gray-100">
                        <span class="text-base font-extrabold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                        <span class="bg-pink-100 text-pink-700 text-xs px-2 py-1 rounded-full font-bold">+ Agregar</span>
                    </div>
                </div>
                @empty
                <p class="col-span-full text-center text-gray-500 py-10">No hay productos disponibles para venta.</p>
                @endforelse
            </div>
        </div>

        <!-- Columna Derecha: Carrito y Cobro -->
        <div class="w-2/5 bg-white p-6 flex flex-col justify-between shadow-xl">
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex justify-between items-center">
                    <span><i class="fa-solid fa-cart-shopping text-pink-600 mr-2"></i> Orden Actual</span>
                    <button onclick="vaciarCarrito()" class="text-xs text-red-500 hover:text-red-700 font-medium">Vaciar lista</button>
                </h2>

                <!-- Tabla de Productos Agregados -->
                <div class="overflow-y-auto max-h-[380px]">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs text-gray-400 uppercase border-b">
                            <tr>
                                <th class="pb-2">Producto</th>
                                <th class="pb-2 text-center">Cant.</th>
                                <th class="pb-2 text-right">Subtotal</th>
                                <th class="pb-2"></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-carrito" class="divide-y divide-gray-100">
                            <!-- Filas dinámicas -->
                        </tbody>
                    </table>
                    <div id="carrito-vacio" class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-basket-shopping text-4xl mb-2"></i>
                        <p class="text-sm">Selecciona productos de la izquierda para comenzar la venta.</p>
                    </div>
                </div>
            </div>

            <!-- Resumen de Pago y Botón procesar -->
            <div class="border-t pt-4 bg-gray-50 p-4 rounded-xl">
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span id="subtotal-txt">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>IVA (16%):</span>
                        <span id="iva-txt">$0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-extrabold text-gray-900 border-t pt-2">
                        <span>Total a Cobrar:</span>
                        <span id="total-txt" class="text-pink-600">$0.00</span>
                    </div>
                </div>

                <button onclick="procesarVenta()" id="btn-cobrar" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3.5 rounded-xl shadow transition text-center cursor-not-allowed">
                    <i class="fa-solid fa-cash-register mr-2"></i> Procesar Venta
                </button>
            </div>
        </div>

    </div>

    <script>
        let carrito = [];

        function agregarAlCarrito(id, nombre, precio, stockMax) {
            let item = carrito.find(p => p.id === id);

            if (item) {
                if (item.cantidad + 1 > stockMax) {
                    Swal.fire({
                        title: 'Stock Límite',
                        text: 'No hay más unidades disponibles de este producto.',
                        icon: 'warning',
                        iconColor: '#db2777',
                        confirmButtonColor: '#be123c',
                        confirmButtonText: 'Entendido',
                        customClass: { popup: 'rounded-2xl p-6 border border-pink-100' }
                    });
                    return;
                }
                item.cantidad++;
            } else {
                carrito.push({ id, nombre, precio, cantidad: 1, stockMax });
            }

            actualizarInterfaz();
        }

        function cambiarCantidad(id, cambio) {
            let item = carrito.find(p => p.id === id);
            if (!item) return;

            item.cantidad += cambio;

            if (item.cantidad <= 0) {
                eliminarDelCarrito(id);
            } else if (item.cantidad > item.stockMax) {
                Swal.fire({
                    title: 'Stock Límite',
                    text: 'No hay más unidades en inventario.',
                    icon: 'warning',
                    iconColor: '#db2777',
                    confirmButtonColor: '#be123c',
                    confirmButtonText: 'Entendido',
                    customClass: { popup: 'rounded-2xl p-6 border border-pink-100' }
                });
                item.cantidad = item.stockMax;
            }

            actualizarInterfaz();
        }

        function eliminarDelCarrito(id) {
            carrito = carrito.filter(p => p.id !== id);
            actualizarInterfaz();
        }

        function vaciarCarrito() {
            if (carrito.length === 0) return;

            Swal.fire({
                title: '¿Vaciar orden?',
                text: 'Se eliminarán todos los productos agregados a la orden actual.',
                icon: 'warning',
                iconColor: '#db2777',
                showCancelButton: true,
                confirmButtonColor: '#be123c',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1.5"></i> Sí, vaciar',
                cancelButtonText: '<i class="fa-solid fa-xmark mr-1.5"></i> Cancelar',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl p-6 shadow-2xl border border-pink-100 bg-white',
                    title: 'text-2xl font-bold text-gray-800',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-white shadow-md',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-white'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    carrito = [];
                    actualizarInterfaz();
                }
            });
        }

        function actualizarInterfaz() {
            const tbody = document.getElementById('tabla-carrito');
            const vacioMsg = document.getElementById('carrito-vacio');
            const btnCobrar = document.getElementById('btn-cobrar');

            tbody.innerHTML = '';

            if (carrito.length === 0) {
                vacioMsg.classList.remove('hidden');
                btnCobrar.disabled = true;
                btnCobrar.className = 'w-full bg-gray-300 text-gray-500 font-bold py-3.5 rounded-xl shadow cursor-not-allowed';
            } else {
                vacioMsg.classList.add('hidden');
                btnCobrar.disabled = false;
                btnCobrar.className = 'w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition cursor-pointer';
            }

            let subtotal = 0;

            carrito.forEach(item => {
                let itemSubtotal = item.precio * item.cantidad;
                subtotal += itemSubtotal;

                tbody.innerHTML += `
                    <tr class="py-2">
                        <td class="py-3 font-medium text-gray-800">${item.nombre}</td>
                        <td class="py-3 text-center">
                            <div class="inline-flex items-center border rounded-lg">
                                <button onclick="cambiarCantidad(${item.id}, -1)" class="px-2 py-0.5 text-gray-600 hover:bg-gray-100">-</button>
                                <span class="px-2 font-bold text-xs">${item.cantidad}</span>
                                <button onclick="cambiarCantidad(${item.id}, 1)" class="px-2 py-0.5 text-gray-600 hover:bg-gray-100">+</button>
                            </div>
                        </td>
                        <td class="py-3 text-right font-bold">$${itemSubtotal.toFixed(2)}</td>
                        <td class="py-3 text-right">
                            <button onclick="eliminarDelCarrito(${item.id})" class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-xmark"></i></button>
                        </td>
                    </tr>
                `;
            });

            let iva = subtotal * 0.16;
            let total = subtotal + iva;

            document.getElementById('subtotal-txt').innerText = `$${subtotal.toFixed(2)}`;
            document.getElementById('iva-txt').innerText = `$${iva.toFixed(2)}`;
            document.getElementById('total-txt').innerText = `$${total.toFixed(2)}`;
        }

        function filtrarProductos() {
            let busqueda = document.getElementById('buscador').value.toLowerCase();
            let productos = document.querySelectorAll('.tarjeta-producto');

            productos.forEach(card => {
                let nombre = card.getAttribute('data-nombre');
                card.style.display = nombre.includes(busqueda) ? 'flex' : 'none';
            });
        }

        function procesarVenta() {
            if (carrito.length === 0) return;

            let totalVal = carrito.reduce((acc, p) => acc + (p.precio * p.cantidad), 0) * 1.16;

            fetch('/pos/procesar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    productos: carrito,
                    total: totalVal
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        title: '¡Venta Registrada!',
                        text: 'La venta ha sido procesada exitosamente.',
                        icon: 'success',
                        iconColor: '#059669',
                        confirmButtonColor: '#831843',
                        confirmButtonText: 'Aceptar',
                        customClass: { popup: 'rounded-2xl p-6 shadow-2xl border border-pink-100' }
                    }).then(() => {
                        vaciarCarrito();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un problema al procesar la venta.',
                        icon: 'error',
                        confirmButtonColor: '#be123c',
                        customClass: { popup: 'rounded-2xl p-6' }
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    title: 'Error de Red',
                    text: 'No se pudo comunicar con el servidor.',
                    icon: 'error',
                    confirmButtonColor: '#be123c',
                    customClass: { popup: 'rounded-2xl p-6' }
                });
            });
        }
    </script>
</body>
</html>
