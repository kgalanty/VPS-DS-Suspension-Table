<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;
class TicketsStatus extends Model
{
    public $timestamps = false;
    protected $table = 'vpsds_tickets_status';
    protected $fillable = ['serviceid', 'suspensionticketdate', 'suspensionticket', 'terminationticketdate', 'terminationticket', 'notes'];
    //protected $visible = ['id', 'userid', 'packageid', 'server', 'regdate', 'domain', 'nextduedate', 'termination_date', 'notes','dedicatedip'];
    protected $hidden = [
        // 'username',
        // 'password',
        // 'accesshash',
        // 'secure',
        // 'port',
    ];
    public function service()
    {
        return $this->belongsTo('\WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service', 'serviceid', 'id');
    }
}