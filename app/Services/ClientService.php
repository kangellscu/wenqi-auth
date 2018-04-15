<?php

namespace App\Services;

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
     */
    public function activateClient(
        string $serialNo, string $macAddr, string $diskSerialNo
    ) {
        // todo
    }
}
