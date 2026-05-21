<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Auditoría #') . $audit->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-2 gap-4 mb-8 pb-4 border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Usuario responsable</p>
                        <p class="text-lg font-bold text-blue-600">{{ $audit->user_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase">Fecha y Hora</p>
                        <p class="text-sm text-gray-600">{{ $audit->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-md font-bold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Cambios Realizados
                    </h3>

                    <div class="grid grid-cols-2 gap-4 font-mono text-xs">
                        <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                            <p class="font-bold text-red-700 mb-2 uppercase">Valor Anterior</p>
                            <pre class="whitespace-pre-wrap">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <p class="font-bold text-green-700 mb-2 uppercase">Valor Nuevo</p>
                            <pre class="whitespace-pre-wrap">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center text-sm text-gray-400">
                    <p>IP: {{ $audit->ip_address }}</p>
                    <a href="{{ route('admin.audits.index') }}" class="text-indigo-600 font-bold hover:underline">Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>