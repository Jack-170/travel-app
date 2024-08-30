<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold custom-main-color text-gray-800">
            {{ __('Elimina Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Una volta eliminato il tuo account, tutte le sue risorse e i dati saranno definitivamente rimossi. Prima di eliminare il tuo account, assicurati di scaricare eventuali dati o informazioni che desideri conservare.') }}
        </p>
    </header>

    <x-danger-button
        class="btn custom-main-color"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Elimina Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold custom-main-color text-gray-800">
                {{ __('Sei sicuro di voler eliminare il tuo account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una volta eliminato il tuo account, tutte le sue risorse e i dati saranno definitivamente rimossi. Inserisci la tua password per confermare che desideri eliminare definitivamente il tuo account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only fw-bold" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="my-3 block w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button class="btn custom-main-color" x-on:click="$dispatch('close')">
                    {{ __('Annulla') }}
                </x-secondary-button>

                <x-danger-button class="btn custom-main-color">
                    {{ __('Elimina Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
