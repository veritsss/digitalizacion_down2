<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Por favor, confirma tu contraseña antes de continuar.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="btn">Confirmar</button>
        </div>
    </form>
</x-guest-layout>
