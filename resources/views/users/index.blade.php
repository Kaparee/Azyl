<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zarządzanie Użytkownikami') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showEditModal: false, showDeleteModal: false, selectedUser: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <form method="GET" action="{{ route('users.index') }}" class="flex gap-2 w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Szukaj po nazwie lub emailu..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">Szukaj</button>
                        </form>
                        <a href="{{ route('users.export-csv') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                            Eksportuj CSV
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200">
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">ID</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Imię / Nazwa</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Email</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Obecna Rola</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 text-right">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-4 py-4 text-sm">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-bold">
                                                {{ $user->role->name ?? 'Brak roli' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right">
                                            <button @click="selectedUser = {{ $user }}; showEditModal = true" class="text-orange-500 hover:text-orange-700 font-medium mr-3">Edytuj Rolę</button>
                                            <button @click="selectedUser = {{ $user }}; showDeleteModal = true" class="text-red-500 hover:text-red-700 font-medium">Usuń</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Brak użytkowników.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showEditModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Zmień Rolę Użytkownika</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" :action="`/users/${selectedUser?.id}`" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Zmieniasz rolę dla: <span class="font-bold text-gray-900" x-text="selectedUser?.name"></span></p>
                        <label class="block text-sm font-medium text-gray-700">Nowa Rola</label>
                        <select name="role_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" x-bind:selected="selectedUser?.role_id == {{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600">Zapisz Zmianę</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showDeleteModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-red-600">Usuwanie Użytkownika</h3>
                    <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" :action="`/users/${selectedUser?.id}`" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <p class="text-sm text-gray-600">Czy na pewno chcesz bezpowrotnie usunąć konto użytkownika <span class="font-bold text-gray-900" x-text="selectedUser?.name"></span>? Tej operacji nie można cofnąć.</p>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Usuń bezpowrotnie</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
