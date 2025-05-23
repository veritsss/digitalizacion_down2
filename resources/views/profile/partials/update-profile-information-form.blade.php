<section>
    <header class="mb-6">
        <h2 id="profile-header" class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Su perfil') }}
        </h2>

        <p id="profile-description" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('patch')

        <!-- Campo para nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                aria-describedby="name-error"
            />
            <x-input-error id="name-error" class="mt-2 text-sm text-red-600" :messages="$errors->get('name')" />
        </div>

        <!-- Campo para correo electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                aria-describedby="email-error"
            />
            <x-input-error id="email-error" class="mt-2 text-sm text-red-600" :messages="$errors->get('email')" />

            <!-- Verificación de correo -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Su correo electrónico no ha sido verificado') }}

                        <button form="send-verification" class="underline text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                            {{ __('Haga click aquí para reenviar la verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nuevo enlace de verificación ha sido enviado a su correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Botón de guardar -->
        <div class="flex items-center gap-4 mt-6">
            <x-primary-button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                {{ __('Guardar') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>

<style>
    /* Estilos generales */
    .text-primary {
        color: #3498db; /* Color principal */
    }

    .text-muted {
        color: #7f8c8d; /* Color secundario */
    }

    .text-sm {
        font-size: 0.875rem; /* Tamaño pequeño */
    }

    .text-green-600 {
        color: #2ecc71;
    }

    .dark\:text-green-400 {
        color: #27ae60;
    }

    /* Estilo para el header */
    #profile-header {
        font-size: 1.125rem; /* tamaño grande */
        font-weight: 500; /* fuente media */
    }

    /* Estilo para la descripción */
    #profile-description {
        margin-top: 0.25rem;
    }

    /* Estilos para los inputs */
    .input-field {
        margin-top: 0.25rem;
        display: block;
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ecf0f1; /* border-light-gray */
        border-radius: 0.5rem; /* bordes redondeados */
    }

    /* Estilos para los botones */
    .hover\:text-primary:hover {
        color: #3498db;
    }

    .dark\:hover\:text-primary-light:hover {
        color: #a3c4fc;
    }

    /* Estilos de enfoque en el botón */
    .focus\:ring-primary:focus {
        ring-color: #3498db;
    }

    /* Ajustes para las notificaciones de estado */
    .font-medium {
        font-weight: 500;
    }

    .mt-4 {
        margin-top: 1rem;
    }

    /* Estilos del botón primario */
    .w-full {
        width: 100%;
    }

    /* Estilos generales para el formulario */
    .space-y-6 {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Ajustes para las animaciones */
    [x-cloak] { display: none; }
</style>
