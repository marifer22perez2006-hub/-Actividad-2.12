<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel Administrativo - B&G Repostería')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

    <!-- Sidebar de Administración -->
    <aside class="w-64 bg-pink-900 text-pink-100 flex flex-col shadow-lg shrink-0 justify-between">
        <div>
            <div class="p-5 text-2xl font-bold border-b border-pink-800 flex items-center gap-2">
                <i class="fa-solid fa-cake-candles text-pink-400"></i>
                <span>Admin B&G</span>
            </div>
            <nav class="p-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('productos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-cookie-bite w-5"></i> Productos
                </a>
                <a href="{{ route('tipos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-layer-group w-5"></i> Tipos de Postre
                </a>
                <a href="{{ route('marcas.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-tags w-5"></i> Marcas
                </a>
                <a href="{{ route('lineas.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-list-check w-5"></i> Líneas
                </a>
                <a href="{{ route('insumos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-boxes-stacked w-5"></i> Insumos
                </a>
                <a href="{{ route('empleados.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-user-tie w-5"></i> Empleados
                </a>
                <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-users w-5"></i> Clientes
                </a>
                <a href="{{ route('pedidos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-pink-800 transition text-sm">
                    <i class="fa-solid fa-receipt w-5"></i> Pedidos / Ventas
                </a>
                <div class="pt-2 border-t border-pink-800">
                    <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-pink-800 hover:bg-pink-700 transition text-sm font-bold text-yellow-300">
                        <i class="fa-solid fa-cash-register w-5"></i> Ir al POS (Caja)
                    </a>
                </div>
            </nav>
        </div>

        <!-- Información del Usuario Autenticado y Cierre de Sesión -->
        <div class="p-4 border-t border-pink-800 bg-pink-950/50 space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-pink-800 text-pink-300 flex items-center justify-center font-bold text-sm shadow-inner border border-pink-700">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::guard('admin')->user()->nombre ?? 'Administrador' }}</p>
                    <p class="text-[10px] text-pink-300 font-semibold truncate">@ {{ Auth::guard('admin')->user()->usuario ?? 'admin' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-xs bg-pink-800 hover:bg-pink-700 text-white font-bold py-2 px-3 rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-right-from-bracket text-pink-300"></i> Cerrar Sesión
                </button>
            </form>
            <div class="text-[10px] text-center text-pink-400 border-t border-pink-900/60 pt-2">
                B&G Repostería &copy; {{ date('Y') }}
            </div>
        </div>
    </aside>

    <!-- Contenedor Derecho Completo -->
    <div class="flex-grow flex flex-col min-w-0">

        <!-- Header / Widget de Geolocalización, Clima y Divisa (Controladores Independientes) -->
        <div id="geo-widget" class="bg-pink-950 text-white px-6 py-2.5 shadow-md flex flex-wrap justify-between items-center text-xs gap-3 border-b border-pink-800 shrink-0">
            <div class="flex flex-wrap items-center gap-4">
                <!-- Ubicación (GeolocalizacionController) -->
                <div class="flex items-center gap-1.5 font-medium text-pink-200" id="widget-ubicacion">
                    <i class="fa-solid fa-location-dot text-pink-400 animate-pulse"></i>
                    <span>Cargando ubicación...</span>
                </div>

                <span class="text-pink-800 hidden sm:inline">|</span>

                <!-- Clima, Humedad y Lluvia (ClimaController) -->
                <div class="flex flex-wrap items-center gap-2" id="widget-clima">
                    <span class="flex items-center gap-1 bg-pink-900/60 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Temperatura actual">
                        <i class="fa-solid fa-temperature-three-quarters text-yellow-400"></i> -- °C
                    </span>
                    <span class="flex items-center gap-1 bg-pink-900/60 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Humedad relativa">
                        <i class="fa-solid fa-droplet text-blue-400"></i> Hum: --%
                    </span>
                    <span class="flex items-center gap-1 bg-pink-900/60 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Probabilidad de Lluvia">
                        <i class="fa-solid fa-cloud-showers-heavy text-indigo-300"></i> Lluvia: --%
                    </span>
                </div>
            </div>

            <!-- Tasa de Cambio Peso / Dólar (DivisaController) -->
            <div class="flex items-center gap-2 font-bold bg-pink-900 px-3 py-1 rounded-full border border-pink-800 text-yellow-300 shadow-sm" id="widget-divisa">
                <i class="fa-solid fa-sack-dollar text-green-400"></i>
                <span>Dólar (USD/MXN): $--.--</span>
            </div>
        </div>

        <!-- Contenido Principal -->
        <main class="flex-grow p-8 overflow-y-auto">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                        <div>
                            <p class="font-bold">¡Éxito!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                        <div>
                            <p class="font-bold">Error de operación</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc pl-5 text-sm mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('contenido')
        </main>
    </div>

    <!-- Script de Carga de los 3 Controladores de APIs y Modal Interactivo -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Petición al Controlador de Geolocalización (GeolocalizacionController)
            fetch('{{ route("api.geolocalizacion") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.ciudad) {
                        document.getElementById('widget-ubicacion').innerHTML = `
                            <i class="fa-solid fa-location-dot text-pink-400"></i>
                            <span class="font-bold text-white">${data.ciudad}, ${data.estado}</span>
                            <span class="text-pink-300">(${data.pais})</span>
                        `;

                        // 2. Petición al Controlador de Clima (ClimaController) pasando latitud y longitud
                        let climaUrl = '{{ route("api.clima") }}';
                        if (data.lat && data.lon) {
                            climaUrl += `?lat=${data.lat}&lon=${data.lon}`;
                        }
                        return fetch(climaUrl);
                    }
                })
                .then(res => res ? res.json() : null)
                .then(data => {
                    if (data && data.temperatura !== undefined) {
                        document.getElementById('widget-clima').innerHTML = `
                            <span class="flex items-center gap-1 bg-pink-900/80 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Temperatura actual">
                                <i class="fa-solid fa-temperature-three-quarters text-yellow-400"></i> ${data.temperatura} °C
                            </span>
                            <span class="flex items-center gap-1 bg-pink-900/80 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Humedad relativa">
                                <i class="fa-solid fa-droplet text-blue-400"></i> ${data.humedad}% Hum.
                            </span>
                            <span class="flex items-center gap-1 bg-pink-900/80 px-2 py-0.5 rounded text-pink-100 font-semibold" title="Probabilidad de Lluvia">
                                <i class="fa-solid fa-cloud-showers-heavy text-indigo-300"></i> ${data.probabilidad_lluvia}% Lluvia
                            </span>
                        `;
                    }
                })
                .catch(err => console.error('Error al conectar con las APIs de geolocalización o clima:', err));

            // 3. Petición al Controlador de Divisas (DivisaController)
            fetch('{{ route("api.divisa") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.usd_mxn) {
                        document.getElementById('widget-divisa').innerHTML = `
                            <i class="fa-solid fa-sack-dollar text-green-400"></i>
                            <span>1 USD = $${data.usd_mxn} MXN</span>
                        `;
                    }
                })
                .catch(err => console.error('Error al conectar con la API de divisa:', err));

            // Interceptar formularios para Modal SweetAlert2 personalizado
            document.querySelectorAll('form').forEach(form => {
                const onsubmitAttr = form.getAttribute('onsubmit');
                if ((onsubmitAttr && onsubmitAttr.includes('confirm')) || form.classList.contains('form-eliminar')) {
                    let mensaje = '¿Seguro que deseas eliminar este registro de la base de datos?';
                    if (onsubmitAttr) {
                        const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                        if (match && match[1]) {
                            mensaje = match[1];
                        }
                    }

                    form.removeAttribute('onsubmit');

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: '¿Confirmar eliminación?',
                            text: mensaje,
                            icon: 'warning',
                            iconColor: '#db2777',
                            showCancelButton: true,
                            confirmButtonColor: '#be123c',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: '<i class="fa-solid fa-trash mr-1.5"></i> Sí, eliminar',
                            cancelButtonText: '<i class="fa-solid fa-xmark mr-1.5"></i> Cancelar',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-2xl p-6 shadow-2xl border border-pink-100 bg-white',
                                title: 'text-2xl font-bold text-gray-800',
                                htmlContainer: 'text-sm text-gray-600 mt-2',
                                confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-white shadow-md transition',
                                cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-white transition'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
