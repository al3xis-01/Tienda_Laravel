<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccederRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccederController extends Controller
{
/**
* Display login page.
*
* @return Renderable
*/
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param AccederRequest $request
     *
     * @return RedirectResponse
     */
    public function login(AccederRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('Acceder')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
