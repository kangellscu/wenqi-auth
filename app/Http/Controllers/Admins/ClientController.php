<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class ClientController extends BaseController
{
    /**
     * list clients
     */
    public function clientList(
        Request $request
    ) {
        return view('admin.clientList');
    }
}
