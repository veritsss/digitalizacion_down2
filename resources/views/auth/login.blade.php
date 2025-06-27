<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="h3 text-black">{{ __('Iniciar Sesión') }}</h1>
        <p class="text-secondary">{{ __('Accede a tu cuenta para continuar') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="p-4 bg-light rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="form-label" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label" for="remember_me">
                {{ __('Recuérdame') }}
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            @if (Route::has('password.request'))
                <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="btn btn-primary">
                {{ __('Acceso') }}
            </x-primary-button>
        </div>
    </form>
    <div class="text-center mt-4">
        <p class="text-secondary">{{ __('¿No tienes una cuenta?') }}</p>
        <a class="text-decoration-none text-primary" href="{{ route('register') }}">
            {{ __('Regístrate aquí') }}
        </a>
    </div>
</x-guest-layout>
