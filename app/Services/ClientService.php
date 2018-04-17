<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Client as ClientModel;
use App\Models\ClientAuthHistory as ClientAuthHistoryModel;
use App\Exceptions\Clients\ClientNotExistsException;
use App\Exceptions\Clients\ClientExistsException;

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

    /**
     * @param string $serialNo
     *
     * @return string           new client id
     */
    public function createNewClient(string $serialNo) : string
    {
        $client = ClientModel::where('serial_no', $serialNo)->first();
        if ($client) {
            throw new ClientExistsException(
                sprintf('软件号: %s 已经存在，请不要重复创建', $serialNo)
            );
        }

        $newClient = ClientModel::create([
            'serial_no' => $serialNo,
            'status'    => ClientModel::STATUS_INIT,
        ]);

        return $newClient->id;
    }

    /**
     * List all clients
     *
     * @return Collection       elements as below:
     *                          - clients Collection
     *                              - id uuid               client primary key
     *                              - serialNo string
     *                              - clientName ?string
     *                              - macAddr ?string
     *                              - diskSerialNo ?string
     *                              - authBeginDate ?\Carbon\Carbon
     *                              - authEndDate ?\Carbon\Carbon
     *                              - statusDesc string
     *                          - totalPages int
     */
    public function listAllClients(?string $serialNo, int $page, int $size) : object
    {
        $query = ClientModel::query();
        if ($serialNo) {
            $query->where('serialNo', $serialNo);
        }
        $offset = ($page - 1) * $size;
        $clients = $query->orderBy('created_at', 'desc')
                         ->offset($offset)
                         ->limit($size)
                         ->get()
                         ->map(function ($client) {
                            return (object) [
                                'id'                => $client->id,
                                'serialNo'          => $client->serial_no,
                                'clientName'        => $client->client_name,
                                'macAddr'        => $client->mac_address,
                                'diskSerialNo'      => $client->disk_serial_no,
                                'authBeginDate'     => $client->auth_begin_date,
                                'authEndDate'       => $client->auth_end_date,
                                'statusDesc'        => $client->statusDesc(),
                            ];
                         });
        $totalRecords = $query->count();
        $totalPages = $totalRecords ? (int) ceil($totalRecords / $size) : 1;

        return (object) [
            'clients'       => $clients,
            'totalPages'    => $totalPages,
        ];
    }

    /**
     * Show edit client form
     *
     * @param string $clientId
     *
     * @return object           properites as below:
     *                          - id string
     *                          - clientName ?string
     *                          - macAddr ?string
     *                          - diskSerialNo ?string
     *                          - authBeginDate ?\Carbon\Carbon
     *                          - authEndDate ?\Carbon\Carbon
     *                          - statusDesc string
     */
    public function getClient(string $clientId) : object
    {
        $client = ClientModel::find($clientId);
        return (object) [
            'id'            => $client->id,
            'serialNo'      => $client->serial_no,
            'clientName'    => $client->client_name,
            'macAddr'       => $client->mac_address,
            'diskSerialNo'  => $client->disk_serial_no,
            'authBeginDate' => $client->auth_begin_date,
            'authEndDate'   => $client->auth_end_date,
            'statusDesc'    => $client->statusDesc(),
        ];
    }

    /**
     * List all client authorization histories
     *
     * @param string $clientId
     * @param int $page
     * @param int $size
     *
     * @return object       properites as below:
     *                      - histories Collection
     *                          - comment ?string
     *                          - createdAt ?\Carbon\Carbon
     *                          - authEndDate ?\Carbon\Carbon
     *                      - totalPages int
     */
    public function listClientAuthorizationHistories(
        string $clientId,
        int $page,
        int $size
    ) : object {
        return (object) [
            'histories'     => collect(),
            'totalPages'    => 0,
        ];
    }
}
