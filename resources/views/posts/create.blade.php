<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Crear Nuevo Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Título del Post</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm">
                @error('name')
                    <small class="text-red-600 font-bold">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Slug (URL)</label>
                <input type="text" name="slug" class="w-full border-gray-300 rounded-md shadow-sm">
                @error('slug')
                    <small class="text-red-600 font-bold">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Extracto</label>
                <textarea name="extract" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                @error('extract')
                    <small class="text-red-600 font-bold">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Guardar Post
            </button>
        </form>
    </div>
</x-app-layout>