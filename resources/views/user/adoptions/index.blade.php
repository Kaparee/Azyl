<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <!-- abstract blobs -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-orange-400/30 to-pink-500/10 rounded-full blur-3xl opacity-70"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold mb-4 border border-orange-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Moje Dokumenty
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Wnioski Adopcyjne</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Tutaj znajdziesz wszystkie złożone przez siebie wnioski o adopcję wraz z ich aktualnym statusem.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col min-h-[400px]">
            @if($applications->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <div class="w-16 h-16 bg-orange-100 text-orange-400 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-gray-900 font-bold mb-2">Brak wniosków</h4>
                    <p class="text-sm text-gray-500 mb-4 max-w-sm">Nie złożyłeś jeszcze żadnego wniosku o adopcję.</p>
                    <a href="{{ url('/') }}" class="text-sm font-bold text-[#FF6B35] hover:text-orange-600 bg-orange-50 px-4 py-2 rounded-full transition-colors">Przeglądaj zwierzęta &rarr;</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($applications as $app)
                        <a href="{{ route('user.adoption-applications.show', $app) }}" class="group relative bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                            <div class="h-32 bg-gradient-to-br from-gray-200 to-gray-300 relative">
                                @if($app->animal->images && $app->animal->images->count() > 0)
                                    <img src="{{ Storage::url($app->animal->images->first()->path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl text-white font-bold opacity-50 bg-gray-400">{{ substr($app->animal->name, 0, 1) }}</div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                                <div class="absolute bottom-3 left-4 text-white">
                                    <h3 class="font-bold text-xl">{{ $app->animal->name }}</h3>
                                    <p class="text-xs text-gray-300">{{ $app->animal->species->name ?? 'Zwierzę' }}</p>
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between bg-white">
                                <div>
                                    <p class="text-xs text-gray-400 mb-3 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Wysłano: {{ $app->created_at->format('d.m.Y H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-600 line-clamp-2 italic">"{{ $app->message ?? 'Brak wiadomości' }}"</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                    @if($app->status->name === 'PENDING')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Oczekujący
                                        </span>
                                    @elseif($app->status->name === 'APPROVED')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Zaakceptowany
                                        </span>
                                    @elseif($app->status->name === 'REJECTED')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Odrzucony
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Anulowany
                                        </span>
                                    @endif
                                    
                                    <span class="text-gray-400 group-hover:text-[#FF6B35] transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
