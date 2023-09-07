<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;

class Service extends Model
{
    public $timestamps = false;
    protected $table = 'tblhosting';
    protected $visible = ['id', 'ticketsstatus', 'domainstatus', 'userid', 'packageid', 'server', 'regdate', 'domain', 'nextduedate', 'termination_date', 'notes', 'dedicatedip', 'product', 'client'];
    protected $casts = [
        'ticketsstatus' => 'array',
    ];
    protected $hidden = [
        // 'username',
        // 'password',
        // 'accesshash',
        // 'secure',
        // 'port',
    ];

    public function getTicketsStatusAttribute($value)
    {
        return (array) $value;
    }
    public function product()
    {
        return $this->belongsTo('\WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Product', 'packageid', 'id');
    }

    public function ticketsstatus()
    {
        return $this->hasOne('\WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketsStatus', 'serviceid', 'id');
    }

    public function client()
    {
        return $this->belongsTo('\WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Client', 'userid', 'id');
    }

    public function scopeServer($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->where('type', 'server');
        });
    }

    public function scopeDuedate($query, $date)
    {
        return $query->where('nextduedate', $date);
    }

    // public function stats()
    // {
    //     return $this->belongsTo('\WHMCS\Module\Addon\LPRManager\app\Models\ServersStats', 'id', 'id');
    // }

    // public function services()
    // {
    //     return $this->hasMany('\WHMCS\Module\Addon\LPRManager\app\Models\Hosting', 'server', 'id');
    // }

    // public function servicesActive()
    // {
    //     return $this->hasMany('\WHMCS\Module\Addon\LPRManager\app\Models\Hosting', 'server', 'id')->where('domainstatus', 'Active');
    // }

    // public function servicesSuspended()
    // {
    //     return $this->hasMany('\WHMCS\Module\Addon\LPRManager\app\Models\Hosting', 'server', 'id')->where('domainstatus', 'Suspended');
    // }
}