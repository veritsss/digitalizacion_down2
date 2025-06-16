<x-guest-layout>
    {{-- El componente x-auth-session-status ya debería generar una alerta de Bootstrap si lo modificaste como se sugirió --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            {{-- x-input-label generará <label class="form-label"> --}}
            <x-input-label for="email" :value="__('Correo electrónico')" />
            {{-- x-text-input generará <input class="form-control"> --}}
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            {{-- x-input-error generará <div class="text-danger"> --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3"> {{-- Equivalente a mt-4 de Tailwind --}}
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="form-control"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3 form-check"> {{-- Equivalente a block mt-4 de Tailwind --}}
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label" for="remember_me">
                {{ __('Recuérdame') }}
            </label>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4"> {{-- Equivalente a flex items-center justify-end mt-4 de Tailwind --}}
            @if (Route::has('password.request'))
                <a class="text-decoration-underline text-secondary me-3" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            {{-- x-primary-button generará <button type="submit" class="btn btn-primary"> --}}
            <x-primary-button class="ms-3">
                {{ __('Acceso') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
