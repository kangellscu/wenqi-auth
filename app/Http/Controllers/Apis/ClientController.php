<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\ClientService;

class ClientController extends BaseController
{
    /**
     * list clients
     */
    public function activateClient(
        Request $request,
        ClientService $clientService,
        string $serialNo
    ) {
        $request->request->set('serialNo', $serialNo);
        $this->validate($request, [
            'serialNo'      => 'required|serial_no',
            'macAddr'       => 'required|string|max:32',
            'diskSerialNo'  => 'required|string|max:32',
        ]);

        // invoke service
        /*
        $success = $clientService->activateClient(
            $request->request->get('serialNo'),
            $request->request->get('macAddr'),
            $request->request->get('diskSerialNo')
        );
        */

        return response()->json([
                'code'      => 0,
                'msg'       => 'success',
                'nonceStr'  => 'f40876c33d414b61bef6a044817dbf99',
                'sign'      => 'sha256 signature',
                'currTimestamp' => time(),
        ]);
    }
}
