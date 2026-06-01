<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wnioski adopcyjne') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 text-sm rounded-xl border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Otrzymane wnioski</h3>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-600">
                        Razem: {{ $applications->total() }}
                    </span>
                </div>

                @if ($applications->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        Brak złożonych wniosków adopcyjnych w systemie.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 text-xs font-bold text-gray-500 uppercase border-b border-gray-100">
                                    <th class="px-6 py-4">Użytkownik</th>
                                    <th class="px-6 py-4">Zwierzę</th>
                                    <th class="px-6 py-4">Wiadomość</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach ($applications as $app)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $app->user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $app->user->email }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-800">{{ $app->animal->name }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ $app->animal->id }}</div>
                                        </td>

                                        <td class="px-6 py-4 max-w-xs truncate text-gray-600"
                                            title="{{ $app->message }}">
                                            {{ $app->message ?? 'Brak wiadomości dodatkowej' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($app->status->name === 'PENDING')
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Oczekujący</span>
                                            @elseif($app->status->name === 'APPROVED')
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Zaakceptowany</span>
                                            @elseif($app->status->name === 'REJECTED')
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Odrzucony</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Anulowany</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            @if ($app->status->name === 'PENDING')
                                                <div class="flex items-center justify-end space-x-2">
                                                    <form
                                                        action="{{ route('admin.adoption-applications.update', $app) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit"
                                                            class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs rounded-lg transition-colors">
                                                            Akceptuj
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route('admin.adoption-applications.update', $app) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="2">
                                                        <button type="submit"
                                                            class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-medium text-xs rounded-lg transition-colors">
                                                            Odrzuć
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400">Brak akcji</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-gray-100">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
