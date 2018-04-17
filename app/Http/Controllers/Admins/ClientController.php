<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\ClientService;

class ClientController extends BaseController
{
    /**
     * List all clients
     */
    public function clientList(
        Request $request,
        ClientService $clientService
    ) {
        $this->validate($request, [
            'serialNo'  => 'serial_no',
            'page'      => 'integer|min:1|max:1000',
            'size'      => 'integer|min:1|max:100',
        ]);

        $page = (int) $request->query->get('page', 1);
        $res = $clientService->listAllClients(
            $request->query->get('serialNo'),
            $page,
            (int) $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.clientList', [
            'clients'       => $res->clients,
            'page'          => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'    => $res->totalPages,
        ]);
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
