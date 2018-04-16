<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\ClientService;

class ClientController extends BaseController
{
    /**
     * List clients
     */
    public function clientList(
        Request $request
    ) {
        return view('admin.clientList');
    }


    /**
     * Show create new client form
     */
    public function showCreateNewClientForm()
    {
        return view('admin.createNewClientForm');
    }


    /**
     * Create new client form
     */
    public function createNewClient(
        Request $request,
        ClientService $clientService
    ) {
        $this->validate($request, [
            'serialNo'  => 'required|serial_no',
        ]);

        $clientService->createNewClient(
            $request->request->get('serialNo')
        );

        return redirect()->route('admin.dashboard');
    }
}
