<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 animate-fade-in-up pb-12">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <!-- abstract blobs -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-purple-500/10 rounded-full blur-3xl opacity-70"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <a href="{{ route('user.adoption-applications.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#FF6B35] font-medium text-sm mb-4 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Wróć do listy wniosków
                    </a>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Szczegóły wniosku</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Złożony dnia: {{ $application->created_at->format('d.m.Y \o H:i') }}</p>
                </div>
                
                <div class="shrink-0">
                    @if($application->status->name === 'PENDING')
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-orange-100 border border-orange-200 shadow-sm">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                            </span>
                            <span class="text-orange-800 font-bold text-lg">Oczekujący</span>
                        </div>
                    @elseif($application->status->name === 'APPROVED')
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-green-100 border border-green-200 shadow-sm">
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            <span class="text-green-800 font-bold text-lg">Zaakceptowany</span>
                        </div>
                    @elseif($application->status->name === 'REJECTED')
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-red-100 border border-red-200 shadow-sm">
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            <span class="text-red-800 font-bold text-lg">Odrzucony</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gray-100 border border-gray-200 shadow-sm">
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-gray-500"></span>
                            <span class="text-gray-800 font-bold text-lg">Anulowany</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- ANIMAL CARD -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                <div class="h-64 bg-gray-200 relative">
                    @if($application->animal->images && $application->animal->images->count() > 0)
                        <img src="{{ Storage::url($application->animal->images->first()->path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-6xl text-white font-bold opacity-50 bg-gray-400">{{ substr($application->animal->name, 0, 1) }}</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-3xl font-black mb-1">{{ $application->animal->name }}</h3>
                        <p class="text-gray-200 font-medium">{{ $application->animal->species->name ?? 'Zwierzę' }} &bull; {{ $application->animal->breed->name ?? 'Mieszaniec' }}</p>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informacje o zwierzaku</h4>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">Płeć</span>
                            <span class="font-bold text-gray-900">{{ $application->animal->gender === 1 ? 'Samiec' : 'Samica' }}</span>
                        </li>
                        <li class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">Wiek</span>
                            <span class="font-bold text-gray-900">{{ $application->animal->age ?? 'Nieznany' }} lat</span>
                        </li>
                        <li class="flex justify-between items-center py-2">
                            <span class="text-gray-500">Status</span>
                            <span class="font-bold text-gray-900">{{ $application->animal->status->name ?? 'W schronisku' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- APPLICATION DETAILS -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col">
                <div class="mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Twoja wiadomość</h3>
                        <p class="text-sm text-gray-500">Wysłana podczas składania wniosku</p>
                    </div>
                </div>
                
                <div class="flex-1 bg-gray-50 rounded-2xl p-6 border border-gray-100 relative">
                    <svg class="absolute top-4 left-4 w-8 h-8 text-gray-200" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-2.2 1.8-4 4-4V8zm16 0c-3.3 0-6 2.7-6 6v10h10V14h-6c0-2.2 1.8-4 4-4V8z"></path></svg>
                    <p class="text-gray-700 leading-relaxed relative z-10 pl-8 pt-2">
                        {!! nl2br(e($application->message ?? 'Brak dodatkowej wiadomości.')) !!}
                    </p>
                </div>
                
                <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl p-5 flex items-start gap-4">
                    <svg class="w-6 h-6 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-blue-900 text-sm mb-1">Co dalej?</h4>
                        <p class="text-sm text-blue-700">Oczekuj na kontakt telefoniczny ze strony naszych pracowników. Jeśli masz pytania, skontaktuj się z biurem podając datę złożenia wniosku.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
