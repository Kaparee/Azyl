<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edytuj aktualność</h2>
            
            <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Tytuł *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                        class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                </div>

                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-2">Treść *</label>
                    <textarea id="content" name="content" rows="10" required
                        class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm">{{ old('content', $news->content) }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Zdjęcie główne</label>
                    @if($news->image)
                        <div class="mb-3">
                            <img src="/storage/{{ $news->image }}" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">Wybierz nowy plik, aby nadpisać obecne zdjęcie.</p>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ $news->is_published ? 'checked' : '' }}
                        class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                    <label for="is_published" class="ml-3 block text-sm font-medium text-gray-700">
                        Opublikowane
                    </label>
                </div>

                <div class="pt-6 flex justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.news.index') }}" class="px-6 py-2 rounded-xl font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                        Anuluj
                    </a>
                    <button type="submit" class="px-6 py-2 rounded-xl font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                        Zaktualizuj
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
