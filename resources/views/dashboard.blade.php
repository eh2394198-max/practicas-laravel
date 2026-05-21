<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - Sesión iniciada como: {{ auth()->user()->getRoleNames()->first() }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                {{-- SECCIÓN PARA EL ADMIN --}}
                @role('admin')
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-blue-600">Panel de Administración</h3>
                        <p class="text-gray-600 mt-1">Bienvenido, Emmanuel. Tienes acceso total para gestionar el contenido.</p>
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- CORRECCIÓN AQUÍ: Quitamos 'admin.' de la ruta --}}
                            <a href="{{ route('posts.index') }}" class="bg-blue-600 text-white p-4 rounded-lg shadow hover:bg-blue-700 text-center font-bold transition">
                                Ver y Gestionar Posts
                            </a>
                            
                            {{-- Botón para crear directamente --}}
                            <a href="{{ route('posts.create') }}" class="bg-indigo-600 text-white p-4 rounded-lg shadow hover:bg-indigo-700 text-center font-bold transition">
                                + Crear Nuevo Artículo
                            </a>
                        </div>
                    </div>
                @endrole

                {{-- SECCIÓN PARA EL ROL VIEW (Emmanuel Ibarra) --}}
                @role('view')
                    <div class="mb-8 text-center">
                        <div class="inline-flex items-center p-2 bg-green-100 text-green-700 rounded-full mb-4">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span class="font-bold text-sm uppercase tracking-wider">Modo Lectura</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Hola, Emmanuel Ibarra</h3>
                        <p class="text-gray-600 mt-2">Has ingresado con permisos de visualización. Puedes explorar el blog libremente.</p>
                        
                        <div class="mt-8">
                            <a href="{{ route('posts.index') }}" class="inline-block bg-gray-900 text-white px-10 py-3 rounded-md font-semibold hover:bg-black transition">
                                Ir al Listado de Posts
                            </a>
                        </div>
                    </div>
                @endrole

            </div>
        </div>
    </div>
</x-app-layout>