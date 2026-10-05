<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('meta_title', $settings['meta_title_default'] ?? 'Marcsol | Supermercado Corporativo en Quevedo')</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description_default'] ?? 'Supermercado líder en Quevedo. Ahorra en alimentos, carnes, lácteos y productos del hogar.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Redes Sociales -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', $settings['meta_title_default'] ?? 'Marcsol | Supermercado Corporativo')">
    <meta property="og:description" content="@yield('meta_description', $settings['meta_description_default'] ?? 'Ahorro y calidad en Quevedo')">
    <meta property="og:image" content="@yield('og_image', asset($settings['og_image_default'] ?? 'images/og-default.jpg'))">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($settings['favicon_url'] ?? 'favicon.ico') }}">

    <!-- Fuentes Google (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Inyección Dinámica de Colores Corporativos (:root) -->
    <style>
        :root {
            --primary-color: {{ $settings['primary_color'] ?? '#0F4C81' }};
            --secondary-color: {{ $settings['secondary_color'] ?? '#F58220' }};
            --accent-color: {{ $settings['accent_color'] ?? '#2ECC71' }};
        }
        body { font-family: 'Inter', sans-serif; }
    </style>

    <!-- Vite Assets (Tailwind CSS + Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Hoja de Estilos Sandbox Override -->
    @if(file_exists(public_path('css/custom-override.css')))
        <link rel="stylesheet" href="{{ asset('css/custom-override.css') }}?v={{ filemtime(public_path('css/custom-override.css')) }}">
    @endif

    <!-- Data Tracking Scripts -->
    @if(!empty($settings['gtm_id']))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $settings['gtm_id'] }}');</script>
    @endif

    @yield('extra_schema')
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">
    <!-- Encabezado de Aterrizaje Minimalista (Landing Header) -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-gray-100 shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-marcsol-primary flex items-center justify-center text-white font-black text-xl shadow">
                    M
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-marcsol-primary">MARCSOL</span>
                    <span class="block text-[9px] font-bold tracking-widest text-marcsol-secondary uppercase -mt-0.5">Supermercado</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="tel:{{ $settings['company_phone'] ?? '+59352759000' }}" class="hidden sm:inline-flex text-xs font-semibold text-gray-700 hover:text-marcsol-primary">
                    📞 {{ $settings['company_phone'] ?? '+593 5 275 9000' }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '593997654321') }}" target="_blank" rel="noopener" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow transition-all flex items-center gap-1.5">
                    <span>Contactar Asesor</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Pie de Página Minimalista (Landing Footer) -->
    <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <p>© {{ date('Y') }} {{ $settings['site_name'] ?? 'Marcsol' }}. Todos los derechos reservados. Quevedo - Ecuador.</p>
            <div class="flex space-x-6">
                <a href="{{ url('/') }}" class="hover:text-white">Inicio</a>
                <a href="{{ url('/sucursales') }}" class="hover:text-white">Sucursales</a>
                <a href="{{ url('/contacto') }}" class="hover:text-white">Contacto</a>
            </div>
        </div>
    </footer>
</body>
</html>
