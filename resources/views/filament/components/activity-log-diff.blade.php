<div class="space-y-4 text-sm">
    {{-- Resumen del Evento --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 text-xs">
        <div>
            <span class="text-gray-400 block">Modelo:</span>
            <span class="font-bold text-gray-800 dark:text-gray-200">{{ class_basename($record->subject_type) }} #{{ $record->subject_id }}</span>
        </div>
        <div>
            <span class="text-gray-400 block">Evento:</span>
            <span class="inline-block px-2 py-0.5 rounded font-bold uppercase text-[10px] 
                {{ $record->description === 'created' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                {{ $record->description === 'updated' ? 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' : '' }}
                {{ $record->description === 'deleted' ? 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300' : 'bg-gray-100 text-gray-800' }}">
                {{ $record->description }}
            </span>
        </div>
        <div>
            <span class="text-gray-400 block">Usuario:</span>
            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $record->causer?->name ?? 'Sistema Automático' }}</span>
        </div>
        <div>
            <span class="text-gray-400 block">Fecha y Hora:</span>
            <span class="text-gray-600 dark:text-gray-400">{{ $record->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>

    {{-- Tabla Comparativa de Cambios --}}
    @php
        $allKeys = array_unique(array_merge(array_keys($old ?? []), array_keys($attributes ?? [])));
    @endphp

    @if(empty($allKeys))
        <div class="p-6 text-center text-gray-500 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
            No se registraron cambios específicos en las propiedades para este evento.
        </div>
    @else
        <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-2.5 px-3 w-1/4">Campo / Atributo</th>
                        @if(!empty($old))
                            <th class="py-2.5 px-3 w-3/8 text-red-600 dark:text-red-400">Valor Anterior</th>
                        @endif
                        <th class="py-2.5 px-3 {{ empty($old) ? 'w-3/4' : 'w-3/8' }} text-emerald-600 dark:text-emerald-400">
                            {{ !empty($old) ? 'Valor Nuevo' : 'Valor Inicial Asignado' }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($allKeys as $key)
                        @php
                            $valOld = $old[$key] ?? null;
                            $valNew = $attributes[$key] ?? null;

                            $isDifferent = $valOld !== $valNew;

                            $formatVal = function($val) {
                                if (is_null($val)) return '<span class="text-gray-400 italic">null</span>';
                                if (is_bool($val)) return $val ? '<span class="text-emerald-600 font-bold">true</span>' : '<span class="text-red-600 font-bold">false</span>';
                                if (is_array($val)) return '<pre class="text-[10px] max-h-24 overflow-auto p-1 bg-gray-950 text-gray-300 rounded font-mono">' . e(json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . '</pre>';
                                return e(Str::limit((string) $val, 150));
                            };
                        @endphp
                        <tr class="{{ $isDifferent && !empty($old) ? 'bg-amber-500/5' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-2.5 px-3 font-mono font-semibold text-gray-900 dark:text-gray-100 align-top">
                                {{ $key }}
                            </td>
                            @if(!empty($old))
                                <td class="py-2.5 px-3 text-gray-700 dark:text-gray-300 align-top bg-red-50/50 dark:bg-red-950/20">
                                    {!! $formatVal($valOld) !!}
                                </td>
                            @endif
                            <td class="py-2.5 px-3 text-gray-700 dark:text-gray-300 align-top bg-emerald-50/50 dark:bg-emerald-950/20">
                                {!! $formatVal($valNew) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
