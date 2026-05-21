<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Crear Nuevo Post con Adjuntos</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                {{-- Título --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Título del Post</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Escribe un título atractivo...">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug (Auto-generado) --}}
                <div>
                    <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug (URL Amigable)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" readonly
                           class="w-full border-gray-300 bg-gray-50 rounded-lg shadow-sm text-gray-500 cursor-not-allowed" 
                           placeholder="se-generara-automaticamente">
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Extracto --}}
                <div>
                    <label for="extract" class="block text-sm font-bold text-gray-700 mb-1">Extracto / Resumen</label>
                    <textarea id="extract" name="extract" rows="3" 
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Breve descripción del post (mínimo 50 caracteres)...">{{ old('extract') }}</textarea>
                    @error('extract')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sección de Archivos --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <label class="block text-sm font-bold text-blue-800 mb-2">Adjuntar Material (Máx. 5 archivos)</label>
                    <input type="file" name="attachments[]" id="attachments" multiple 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                    
                    <div class="flex items-center mt-2 text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs italic">Permitidos: JPG, PNG, PDF, DOC, DOCX (Máx. 5MB)</span>
                    </div>

                    @error('attachments')
                        <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                    @error('attachments.*')
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end mt-8 gap-3">
                <a href="{{ route('posts.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform active:scale-95">
                    Publicar Post y Archivos
                </button>
            </div>
        </form>
    </div>

    {{-- Script para generar el Slug automáticamente --}}
    <script>
        document.getElementById('name').addEventListener('keyup', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                            .replace(/[^\w ]+/g, '')
                            .replace(/ +/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
</x-app-layout>