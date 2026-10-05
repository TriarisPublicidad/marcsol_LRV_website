@php
    $items = $data['items'] ?? [];
@endphp
@if(count($items) > 0)
    <section class="py-16 bg-gray-50 border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Respuestas Rápidas</span>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">
                    {{ $data['titulo'] ?? 'Preguntas Frecuentes' }}
                </h2>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                @foreach($items as $idx => $item)
                    <div class="rounded-2xl bg-white border border-gray-200 overflow-hidden shadow-sm transition">
                        <button
                            @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                            class="w-full p-5 text-left font-bold text-gray-900 flex justify-between items-center gap-4 hover:text-marcsol-primary"
                        >
                            <span>{{ $item['pregunta'] ?? '' }}</span>
                            <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200" :class="{ 'rotate-180': active === {{ $idx }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="active === {{ $idx }}" x-collapse class="px-5 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
                            {!! nl2br(e($item['respuesta'] ?? '')) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
