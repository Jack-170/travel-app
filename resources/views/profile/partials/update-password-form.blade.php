<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold custom-main-color text-gray-800">
            {{ __('Aggiorna Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assicurati che il tuo account utilizzi una password lunga e casuale per rimanere sicuro.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Attuale')" class="fw-bold" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-2 block w-full"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nuova Password')" class="fw-bold" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-2 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Conferma Password')" class="fw-bold" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-2 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button class="btn custom-main-color">
                {{ __('Salva') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Salvato.') }}
                </p>
            @endif
        </div>
    </form>
</section>
