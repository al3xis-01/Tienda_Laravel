<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroRequest;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RegistroController extends Controller
{
    /**
     * Display register page.
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param RegistroRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function register(RegistroRequest $request)
    {

        $request->validated();

        $user = new Usuario();
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->username = $request->username;
        $user->tipo = 'USER';
        $user->estado = 1;
        $user->email = $request->email;
        $user->password = password_hash($request->password,PASSWORD_DEFAULT);

        $user->save();

        $cliente = new Cliente();
        $cliente->id_usuario = $user->id;
        $cliente->credito = 1000;
        $cliente->save();

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
