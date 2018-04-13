<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    const STATUS_INIT = 1;
    const STATUS_ACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',        // client software serial_no, eg: F001
        'client_name',      // edited by admin
        'mac_address',      // mac address of pc on which client running
        'disk_serial_no',   // disk serial no
        'auth_begin_date',
        'auth_end_date',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['auth_begin_date', 'auth_end_date'];
}
