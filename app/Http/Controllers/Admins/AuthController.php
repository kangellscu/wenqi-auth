<?php

namespace App\Http\Controllers\Admins;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller as BaseController;

class AuthController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username()   => 'required|string|max:32',
            'password'          => 'required|password',
        ]);
    }

    public function username() : string
    {
        return 'name';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function redirectTo() : string
    {
        return 'admin/clients';
    }
}
