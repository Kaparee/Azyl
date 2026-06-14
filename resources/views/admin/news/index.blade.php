<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Zarządzanie Aktualnościami</h2>
            <a href="{{ route('admin.news.create') }}" class="bg-[#FF6B35] hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition-colors">
                + Dodaj aktualność
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tytuł</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data utworzenia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($news as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->author->name ?? 'Nieznany' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->is_published)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Opublikowane</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Szkic</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.news.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edytuj</a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę aktualność?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                Brak aktualności do wyświetlenia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
