<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-4xl font-bold text-gray-900 mb-2">Zaloguj się</h2>
        <p class="text-lg text-gray-600">Witaj z powrotem! Wpisz swoje dane, aby się zalogować.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Adres E-Mail')" class="text-lg font-medium" />
            <x-text-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="jan.kowalski@poczta.pl" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Hasło')" class="text-lg font-medium" />
            <x-text-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-8">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500 w-5 h-5">
                <span class="ms-3 text-base text-gray-600">Zapamiętaj mnie</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-base text-orange-500 hover:text-orange-600 font-medium" href="{{ route('password.request') }}">
                    Zapomniałeś hasła?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                Zaloguj się
            </button>
        </div>
        
        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-orange-50 text-gray-500">lub</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Zaloguj przez Google</span>
                <span class="text-blue-600 font-bold mr-2">G</span> Google
            </a>
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Zaloguj przez Facebook</span>
                <span class="text-blue-600 font-bold mr-2">f</span> Facebook
            </a>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Nie masz konta? 
            <a href="{{ route('register') }}" class="font-medium text-orange-500 hover:text-orange-600">
                Zarejestruj się
            </a>
        </p>
    </form>
</x-guest-layout>
