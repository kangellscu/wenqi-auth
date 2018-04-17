<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
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
        $success = $clientService->activateClient(
            $request->request->get('serialNo'),
            $request->request->get('macAddr'),
            $request->request->get('diskSerialNo')
        );

        return $this->json();
    }

    
    /**
     * Get auth info
     */
    public function getAuthInfo(
        Request $request,
        ClientService $clientService,
        string $serialNo
    ) {
        $request->request->set('serialNo', $serialNo);
        $this->validate($request, [
            'serialNo'      => 'required|serial_no',
        ]);

        $authInfo = $clientService->getAuthorization($serialNo);

        return $this->json([
            'authBeginDate' => $authInfo->authBeginDate ?
                $authInfo->authBeginDate->format('Y-m-d') : null,
            'authEndDate'   => $authInfo->authEndDate ?
                $authInfo->authEndDate->format('Y-m-d') : null,
        ]);
    }
}
