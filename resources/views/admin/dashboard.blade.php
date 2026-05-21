<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Posts</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_posts }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Usuarios</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_users }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Auditorías Hoy</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $recent_audits->count() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Bitácora de Auditoría Reciente</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recent_audits as $audit)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $audit->user_name }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-1 rounded text-xs font-bold {{ $audit->action == 'created' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ strtoupper($audit->action) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $audit->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Últimos Posts Creados</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($recent_posts as $post)
                            <li class="py-3 flex justify-between">
                                <span class="text-sm font-medium text-gray-900">{{ $post->name }}</span>
                                <span class="text-sm text-gray-500">{{ $post->created_at->format('d/m/Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>