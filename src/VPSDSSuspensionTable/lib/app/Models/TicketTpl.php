<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;
use Illuminate\Database\Eloquent\Builder;
class TicketTpl extends Model
{
    public $timestamps = false;
    protected $table = 'vpsds_tickettpl';
    protected $fillable = ['name', 'title', 'content'];
    //protected $visible = ['id', 'userid', 'packageid', 'server', 'regdate', 'domain', 'nextduedate', 'termination_date', 'notes','dedicatedip'];
    protected $hidden = [
    ];
}