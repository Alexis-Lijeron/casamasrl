<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login(LoginRequest $request)
    {
        $key = 'login_attempts:' . $request->ip(); // Clave única basada en la IP del usuario

        // Verificar si el usuario está bloqueado
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'login_invalid' => "Demasiados intentos fallidos. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        $credentials = $request->only('email', 'password');

        // Verificar credenciales
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Limpiar los intentos fallidos después de un inicio de sesión exitoso
            RateLimiter::clear($key);

            return redirect()->intended(route('dashboard'));
        }

        // Incrementar intentos fallidos
        RateLimiter::hit($key, 600); // Bloqueo de 10 minutos tras demasiados intentos

        return back()->withErrors([
            'login_invalid' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.index'));
    }
}
