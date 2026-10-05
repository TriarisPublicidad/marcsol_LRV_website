<section class="py-16 bg-gradient-to-r from-marcsol-primary to-blue-950 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
        <h2 class="text-3xl sm:text-4xl font-black tracking-tight max-w-3xl mx-auto leading-tight">
            {{ $data['titulo'] ?? '¿Tienes un Negocio en Quevedo? Cotiza al por Mayor con Nosotros' }}
        </h2>
        @if(!empty($data['subtitulo']))
            <p class="text-slate-300 max-w-2xl mx-auto text-base">
                {{ $data['subtitulo'] }}
            </p>
        @endif
        <div class="pt-2">
            <a href="{{ $data['boton_url'] ?? url('/contacto') }}" class="inline-block px-8 py-4 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-xl transition-all transform hover:-translate-y-0.5">
                {{ $data['boton_texto'] ?? 'Contactar Asesor B2B' }}
            </a>
        </div>
    </div>
</section>
