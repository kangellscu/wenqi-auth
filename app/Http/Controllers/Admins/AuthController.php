<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * Show login page
     */
    public function loginPage()
    {
        return view('admin.login');
    }
}
