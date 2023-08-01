<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;
use Illuminate\Database\Eloquent\Builder;
class TicketsStatus extends Model
{
    public $timestamps = false;
    protected $table = 'vpsds_tickets_status';
    protected $fillable = ['serviceid', 'suspensionticketdate', 'suspensionticket', 'terminationticketdate', 'terminationticket', 'notes','color', 'deleted_at'];
    //protected $visible = ['id', 'userid', 'packageid', 'server', 'regdate', 'domain', 'nextduedate', 'termination_date', 'notes','dedicatedip'];
    protected $hidden = [
        // 'username',
        // 'password',
        // 'accesshash',
        // 'secure',
        // 'port',
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->whereNull('deleted_at');
        });
    }

    public function service()
    {
        return $this->belongsTo('\WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service', 'serviceid', 'id');
    }
}