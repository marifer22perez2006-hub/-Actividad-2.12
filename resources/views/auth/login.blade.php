<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - B&G Repostería</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-pink-950 via-pink-900 to-pink-800 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-pink-100">
        <!-- Encabezado del Formulario -->
        <div class="bg-pink-900 p-8 text-center text-white relative">
            <div class="w-20 h-20 bg-pink-800 text-pink-300 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner border-2 border-pink-400">
                <i class="fa-solid fa-cake-candles text-4xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold tracking-wide">B&G Repostería</h1>
            <p class="text-xs text-pink-200 mt-1">Panel de Control Administrativo</p>
        </div>

        <!-- Cuerpo del Formulario -->
        <div class="p-8">

            <!-- Mensajes de Alerta y Errores de Autenticación -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-5 rounded-xl text-xs font-semibold flex items-center gap-2" role="alert">
                    <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-5 rounded-2xl shadow-sm text-xs space-y-1">
                    <p class="font-bold flex items-center gap-1.5 text-sm text-red-800">
                        <i class="fa-solid fa-circle-exclamation text-red-600"></i> Error de inicio de sesión
                    </p>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li class="font-semibold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Campo Usuario -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Usuario Administrador</label>
                    <div class="relative">
                        <input type="text" name="usuario" value="{{ old('usuario') }}" placeholder="Ej. admin" required autofocus
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 text-sm focus:border-pink-600 focus:ring-2 focus:ring-pink-200 outline-none transition">
                        <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Contraseña</label>
                    <div class="relative">
                        <input type="password" name="contraseña" placeholder="••••••••" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 text-sm focus:border-pink-600 focus:ring-2 focus:ring-pink-200 outline-none transition">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Botón de Iniciar Sesión -->
                <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                </button>
            </form>

            <!-- Separador -->
            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                <div class="relative flex justify-center text-[11px] uppercase"><span class="bg-white px-3 text-gray-400 font-bold">O accede con</span></div>
            </div>

            <!-- Botón de Inicio de Sesión con Google API (Socialite OAuth) -->
            <a href="{{ route('auth.google') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-bold py-3 px-4 rounded-xl border border-gray-300 shadow-sm transition duration-200 flex items-center justify-center gap-3 text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Continuar con Google</span>
            </a>

            <!-- Nota Informativa para Pruebas -->
            <div class="mt-6 pt-4 border-t text-center text-xs text-gray-500 bg-gray-50 p-3 rounded-xl">
                <p class="font-bold text-gray-700"><i class="fa-solid fa-key text-pink-600 mr-1"></i> Credenciales Demo:</p>
                <p class="mt-0.5">Usuario: <span class="font-mono font-bold text-pink-700">admin</span> | Clave: <span class="font-mono font-bold text-pink-700">admin123</span></p>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-3 text-center text-[10px] text-gray-400 border-t">
            Sistema B&G Repostería &bull; API Autenticación Social Google OAuth (`laravel/socialite`)
        </div>
    </div>

</body>
</html>
