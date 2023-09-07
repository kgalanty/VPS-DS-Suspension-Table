<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;
class Product extends Model
{
    public $timestamps = false;
    protected $table = 'tblproducts';
    protected $hidden = [
        // 'username',
        // 'password',
        // 'accesshash',
        // 'secure',
        // 'port',
    ];
    protected $visible = ['id', 'type', 'gid', 'name', 'description', 'hidden'];

    // public function scopeID($query, $serverid)
    // {
    //     return $query->where('id', $serverid);
    // }

    // public function scopeEnabled($query)
    // {
    //     return $query->where('disabled', 0);
    // }

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