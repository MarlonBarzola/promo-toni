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
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|unique:users,cedula',
            'ciudad' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'usuario' => 'required|string|max:255|unique:users,usuario',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'ciudad' => $request->ciudad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',
        ]);

        event(new Registered($user));
        return back();
    }
}
