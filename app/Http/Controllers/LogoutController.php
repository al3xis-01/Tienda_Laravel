<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return Redirector
     */
    public function perform()
    {
        Session::flush();

        Auth::logout();

        return redirect('Acceder');
    }
}
