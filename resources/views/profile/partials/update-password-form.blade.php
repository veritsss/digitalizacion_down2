<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Asegúrese de que su cuenta utilice una contraseña larga para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Campo para la contraseña actual -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full sm:w-3/4"
                autocomplete="current-password"
                aria-describedby="current-password-error"
            />
            <x-input-error id="current-password-error" :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- Campo para la nueva contraseña -->
        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full sm:w-3/4"
                autocomplete="new-password"
                aria-describedby="password-error"
            />
            <x-input-error id="password-error" :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full sm:w-3/4"
                autocomplete="new-password"
                aria-describedby="password-confirmation-error"
            />
            <x-input-error id="password-confirmation-error" :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botón de guardar y mensaje de confirmación -->
        <div class="flex items-center gap-4 mt-6">
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Guardar') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Guardada.') }}</p>
            @endif
        </div>
    </form>
</section>
