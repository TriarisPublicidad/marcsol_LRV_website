@extends('layouts.app')

@section('meta_title', 'Contacto y Ventas Corporativas | Marcsol Quevedo')
@section('meta_description', 'Comunícate con Marcsol para ventas corporativas, atención al cliente o sugerencias en Quevedo, Los Ríos.')

@section('content')
<div class="bg-slate-900 py-12 text-white border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Atención Personalizada</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-1">Canales de Contacto</h1>
        <p class="text-sm text-gray-300 mt-2 max-w-2xl">Estamos para servirte en tus compras cotidianas o requerimientos corporativos.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Información de Canales Directos -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-xl font-bold text-gray-900">Oficinas y Servicio al Cliente</h3>

                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">📍</span>
                        <div>
                            <strong class="text-gray-900 block">Sede Central:</strong>
                            <p>{{ $settings['company_address'] ?? 'Av. 7 de Octubre #402 y Calle Cuarta, Quevedo, Ecuador' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">📞</span>
                        <div>
                            <strong class="text-gray-900 block">Central Telefónica:</strong>
                            <a href="tel:{{ $settings['company_phone'] ?? '+59352759000' }}" class="text-marcsol-primary font-semibold hover:underline">
                                {{ $settings['company_phone'] ?? '+593 5 275 9000' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">💬</span>
                        <div>
                            <strong class="text-gray-900 block">Línea Directa WhatsApp:</strong>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '593997654321') }}" target="_blank" rel="noopener" class="text-emerald-600 font-semibold hover:underline">
                                {{ $settings['company_whatsapp'] ?? '+593 99 765 4321' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">✉️</span>
                        <div>
                            <strong class="text-gray-900 block">Correo Institucional:</strong>
                            <p>{{ $settings['company_email'] ?? 'contacto@marcsol.com.ec' }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 text-xs text-blue-950 space-y-1">
                    <p class="font-bold">💼 ¿Compras para tu Negocio o Institución?</p>
                    <p>Contamos con ejecutivos dedicados para ventas al por mayor en restaurantes, hoteles y distribuidores de Los Ríos.</p>
                </div>
            </div>
        </div>

        <!-- Formulario de Contacto Protegido con CSRF -->
        <div class="lg:col-span-7">
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                <div>
                    <h3 class="text-2xl font-black text-gray-900">Envíanos un Mensaje</h3>
                    <p class="text-xs text-gray-500 mt-1">Completa los campos a continuación y te responderemos en el transcurso del día.</p>
                </div>

                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1">
                        <p class="font-bold">Por favor verifica los campos:</p>
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/contacto') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Nombre Completo *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Teléfono o Celular</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Tipo de Solicitud *</label>
                            <select name="tipo_solicitud" required class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                                <option value="cliente" {{ old('tipo_solicitud') === 'cliente' ? 'selected' : '' }}>Atención al Cliente / Ofertas</option>
                                <option value="corporativo" {{ old('tipo_solicitud') === 'corporativo' ? 'selected' : '' }}>Cotización / Ventas Corporativas</option>
                                <option value="proveedor" {{ old('tipo_solicitud') === 'proveedor' ? 'selected' : '' }}>Propuesta de Proveedor</option>
                                <option value="reclamo" {{ old('tipo_solicitud') === 'reclamo' ? 'selected' : '' }}>Sugerencia o Reclamo</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Sucursal de Preferencia</label>
                        <select name="sucursal" class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                            <option value="">Cualquiera / No aplica</option>
                            @foreach($sucursales as $suc)
                                <option value="{{ $suc->nombre }}" {{ old('sucursal') === $suc->nombre ? 'selected' : '' }}>{{ $suc->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Mensaje o Detalle de Cotización *</label>
                        <textarea name="mensaje" rows="4" required class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">{{ old('mensaje') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold bg-marcsol-primary hover:bg-blue-900 text-white shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>Enviar Solicitud</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
