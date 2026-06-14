<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-4xl font-bold text-gray-900 mb-2">Zarejestruj się</h2>
        <p class="text-lg text-gray-600">Dołącz do nas i pomóż zwierzakom znaleźć nowy dom!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <x-input-label for="name" :value="__('Imię i nazwisko')" class="text-lg font-medium" />
            <x-text-input id="name" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Jan Kowalski" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Adres E-Mail')" class="text-lg font-medium" />
            <x-text-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="jan.kowalski@poczta.pl" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Rola -->
        <div class="mb-5">
            <x-input-label for="role_id" :value="__('Dołączam jako')" class="text-lg font-medium" />
            <select id="role_id" name="role_id" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3" required>
                <option value="" disabled selected>Wybierz rolę...</option>
                <option value="4" @selected(old('role_id') == 4)>Wolontariusz</option>
                <option value="5" @selected(old('role_id') == 5)>Adoptujący</option>
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Hasło')" class="text-lg font-medium" />
            <x-text-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-8">
            <x-input-label for="password_confirmation" :value="__('Potwierdź hasło')" class="text-lg font-medium" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg p-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                Utwórz konto
            </button>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Masz już konto? 
            <a href="{{ route('login') }}" class="font-medium text-orange-500 hover:text-orange-600">
                Zaloguj się
            </a>
        </p>
    </form>
</x-guest-layout>
