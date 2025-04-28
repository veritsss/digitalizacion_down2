<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'string', 'regex:/^\d{1,2}\.\d{3}\.\d{3}-[0-9kK]{1}$/', function ($attribute, $value, $fail) {
                if (!$this->isValidRut($value)) {
                    $fail('El RUT ingresado no es válido.');
                }
            }],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:profesor,estudiante'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'rut' => $request->rut,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
    private function isValidRut($rut)
{
    // Eliminar puntos y guión
    $rut = str_replace(['.', '-'], '', $rut);

    // Separar el cuerpo del dígito verificador
    $body = substr($rut, 0, -1);
    $dv = strtoupper(substr($rut, -1)); // Convertir el dígito verificador a mayúscula

    // Validar que el cuerpo sea numérico
    if (!ctype_digit($body)) {
        return false;
    }

    // Calcular el dígito verificador
    $sum = 0;
    $factor = 2;

    for ($i = strlen($body) - 1; $i >= 0; $i--) {
        $sum += $body[$i] * $factor;
        $factor = $factor == 7 ? 2 : $factor + 1;
    }

    $calculatedDv = 11 - ($sum % 11);

    if ($calculatedDv == 11) {
        $calculatedDv = '0';
    } elseif ($calculatedDv == 10) {
        $calculatedDv = 'K';
    } else {
        $calculatedDv = (string) $calculatedDv;
    }

    // Comparar el dígito verificador calculado con el ingresado
    return $calculatedDv === $dv;
}
}
