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

    <!-- Hoja de Estilos Sandbox Override de Producción -->
    @if(file_exists(public_path('css/custom-override.css')))
        <link rel="stylesheet" href="{{ asset('css/custom-override.css') }}?v={{ filemtime(public_path('css/custom-override.css')) }}">
    @endif

    <!-- Data Tracking: Google Tag Manager -->
    @if(!empty($settings['gtm_id']))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $settings['gtm_id'] }}');</script>
    @endif

    <!-- Data Tracking: Meta Pixel -->
    @if(!empty($settings['meta_pixel_id']))
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings['meta_pixel_id'] }}');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $settings['meta_pixel_id'] }}&ev=PageView&noscript=1"
        /></noscript>
    @endif

    <!-- Data Tracking: Microsoft Clarity -->
    @if(!empty($settings['clarity_id']))
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "{{ $settings['clarity_id'] }}");
        </script>
    @endif

    <!-- Scripts personalizados en <head> -->
    @if(!empty($settings['custom_head_scripts']))
        {!! $settings['custom_head_scripts'] !!}
    @endif

    <!-- Schema.org JSON-LD Estructurado -->
    @php
        $schemaType = $settings['schema_type'] ?? 'Supermarket';
    @endphp
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "{{ $schemaType }}",
      "name": "{{ $settings['site_name'] ?? 'Marcsol' }}",
      "description": "{{ $settings['site_tagline'] ?? 'Supermercado Corporativo en Quevedo' }}",
      "url": "{{ url('/') }}",
      "telephone": "{{ $settings['company_phone'] ?? '+593 5 275 9000' }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $settings['company_address'] ?? 'Av. 7 de Octubre, Quevedo' }}",
        "addressLocality": "Quevedo",
        "addressRegion": "Los Ríos",
        "addressCountry": "EC"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -1.0254000,
        "longitude": -79.4642000
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "07:30",
          "closes": "21:30"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Sunday"],
          "opens": "08:00",
          "closes": "20:00"
        }
      ]
    }
    </script>
    @yield('extra_schema')
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">
    <!-- Google Tag Manager (noscript) -->
    @if(!empty($settings['gtm_id']))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['gtm_id'] }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <!-- Barra Superior de Notificaciones / Atención -->
    <div class="bg-marcsol-primary text-white text-xs py-2 px-4 border-b border-white/10">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1 font-semibold text-amber-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Supermercado Corporativo
                </span>
                <span class="hidden md:inline text-white/70">|</span>
                <span class="hidden md:inline text-white/80">Quevedo - Los Ríos, Ecuador</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:{{ $settings['company_phone'] ?? '+59352759000' }}" class="hover:text-amber-300 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $settings['company_phone'] ?? '+593 5 275 9000' }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '593997654321') }}" target="_blank" rel="noopener" class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-2 py-0.5 rounded transition-colors flex items-center gap-1">
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navegación Principal (Header) -->
    <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logotipo -->
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-marcsol-primary flex items-center justify-center text-white font-black text-2xl shadow-md">
                            M
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight text-marcsol-primary">MARCSOL</span>
                            <span class="block text-[10px] font-bold tracking-widest text-marcsol-secondary uppercase -mt-1">Supermercado</span>
                        </div>
                    </a>
                </div>

                <!-- Enlaces Desktop (desde tabla menu_items) -->
                <nav class="hidden lg:flex items-center space-x-1">
                    @forelse($headerMenus as $item)
                        @if(is_object($item) && isset($item->titulo))
                            @if(isset($item->children) && is_iterable($item->children) && count($item->children) > 0)
                                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                    <button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-marcsol-primary rounded-lg transition-colors flex items-center gap-1">
                                        {{ $item->titulo }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                        @foreach($item->children as $child)
                                            @if(is_object($child) && isset($child->titulo))
                                                <a href="{{ $child->url }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-marcsol-primary">
                                                    {{ $child->titulo }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $item->url }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->is(trim($item->url, '/')) || (request()->is('/') && $item->url === '/') ? 'text-marcsol-primary bg-blue-50/70' : 'text-gray-700 hover:text-marcsol-primary hover:bg-gray-50' }}">
                                    {{ $item->titulo }}
                                </a>
                            @endif
                        @endif
                    @empty
                        <a href="{{ url('/') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-marcsol-primary">Inicio</a>
                        <a href="{{ url('/promociones') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-marcsol-primary">Promociones</a>
                        <a href="{{ url('/sucursales') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-marcsol-primary">Sucursales</a>
                    @endforelse
                </nav>

                <!-- Acciones / CTA -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ url('/promociones') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold bg-marcsol-secondary text-white hover:brightness-105 shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Ofertas del Día
                    </a>
                </div>

                <!-- Botón Menú Móvil -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú Móvil Desplegable -->
        <div x-show="mobileMenuOpen" x-transition class="lg:hidden bg-white border-b border-gray-200 px-4 pt-2 pb-6 space-y-2">
            @foreach($headerMenus as $item)
                @if(is_object($item) && isset($item->titulo))
                    <a href="{{ $item->url }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-marcsol-primary">
                        {{ $item->titulo }}
                    </a>
                @endif
            @endforeach
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ url('/promociones') }}" class="block text-center w-full px-4 py-3 rounded-xl font-bold bg-marcsol-secondary text-white shadow">
                    Ver Promociones Activas
                </a>
            </div>
        </div>
    </header>

    <!-- Contenido Dinámico Principal -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Pie de Página (Footer) -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Columna 1: Info Corporativa -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-marcsol-primary flex items-center justify-center text-white font-black text-xl">
                            M
                        </div>
                        <span class="text-2xl font-black tracking-tight text-white">MARCSOL</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">
                        {{ $settings['site_tagline'] ?? 'Supermercado Corporativo con variedad, frescura garantizada y los precios más bajos de Quevedo.' }}
                    </p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>📍 {{ $settings['company_address'] ?? 'Quevedo, Los Ríos, Ecuador' }}</p>
                        <p>📞 {{ $settings['company_phone'] ?? '+593 5 275 9000' }}</p>
                        <p>✉️ {{ $settings['company_email'] ?? 'contacto@marcsol.com.ec' }}</p>
                    </div>
                </div>

                <!-- Columna 2: Enlaces Rápidos -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-marcsol-secondary pl-3">
                        Navegación
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        @foreach($footerMenus as $item)
                            @if(is_object($item) && isset($item->titulo))
                                <li>
                                    <a href="{{ $item->url }}" class="hover:text-amber-400 transition-colors">
                                        {{ $item->titulo }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- Columna 3: Horarios en Quevedo -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-marcsol-secondary pl-3">
                        Horarios de Atención
                    </h4>
                    <ul class="space-y-2 text-xs text-gray-400">
                        <li class="flex justify-between py-1 border-b border-gray-800">
                            <span>Lunes a Sábado:</span>
                            <span class="text-gray-200 font-medium">07:30 - 21:30</span>
                        </li>
                        <li class="flex justify-between py-1 border-b border-gray-800">
                            <span>Domingos y Feriados:</span>
                            <span class="text-gray-200 font-medium">08:00 - 20:00</span>
                        </li>
                        <li class="pt-2 text-gray-500">
                            Atención continua en nuestras 3 sucursales en Quevedo (Matriz Centro, San Camilo y El Guayacán).
                        </li>
                    </ul>
                </div>

                <!-- Columna 4: Canal Corporativo -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-marcsol-secondary pl-3">
                        Ventas Corporativas
                    </h4>
                    <p class="text-xs text-gray-400 leading-relaxed mb-4">
                        Atención preferencial a negocios, hoteles, restaurantes y empresas de Quevedo con facturación directa y descuentos por volumen.
                    </p>
                    <a href="{{ url('/contacto') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold transition-colors">
                        <span>Contactar Asesor B2B</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-gray-800 text-xs text-gray-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>© {{ date('Y') }} {{ $settings['site_name'] ?? 'Marcsol' }}. Todos los derechos reservados. Quevedo - Ecuador.</p>
                <div class="flex space-x-6">
                    <a href="{{ url('/politicas-de-privacidad') }}" class="hover:text-gray-300">Privacidad</a>
                    <a href="{{ url('/terminos-y-condiciones') }}" class="hover:text-gray-300">Términos</a>
                    <a href="{{ url('/admin') }}" class="hover:text-gray-300 text-gray-600">Acceso Colaboradores</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts personalizados al cierre de <body> -->
    @if(!empty($settings['custom_body_scripts']))
        {!! $settings['custom_body_scripts'] !!}
    @endif
</body>
</html>
