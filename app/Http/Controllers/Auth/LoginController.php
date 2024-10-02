<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function customLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => 'Usuario logueado'], 200);
        }

        // Autenticación fallida
        return response()->json(['error' => 'Email o contraseña incorrectos'], 401);

    }

    protected function authenticated(Request $request, $user)
    {
        return new JsonResponse(['success' => 'Usuario logueado correctamente'], 201);
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Devuelve una respuesta JSON indicando que el usuario ha cerrado sesión correctamente
        return new JsonResponse(['success' => 'Usuario desconectado correctamente'], 200);
    }
}
