<?php

namespace App\Services;

use App\Models\Client as ClientModel;
use App\Models\ClientAuthHistory as ClientAuthHistoryModel;
use App\Exceptions\Clients\ClientNotExistsException;

class ClientService
{
    /**
     * Client activate software
     *
     * @param string $serialNo      client uniq id
     * @param string $macAddr       machine mac address which client
     *                              running on it
     * @param string $diskSerialNo  disk serial no which client
     *                              running on it
     *
     * @return bool
     */
    public function activateClient(
        string $serialNo, string $macAddr, string $diskSerialNo
    ) : bool {
        $client = ClientModel::where('serial_no', $serialNo)->first();
        if ( ! $client) {
            throw new ClientNotExistsException('软件编号不存在，请联系管理人员添加');
        }
        if ($client->isActivate()) {
            return true;
        }

        $client->activate()->save();

        return true;
    }
}
