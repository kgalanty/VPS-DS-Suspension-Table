<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models;

use Illuminate\Database\Eloquent\Model;
use WHMCS\Database\Capsule as DB;
class Client extends Model
{
    public $timestamps = false;
    protected $table = 'tblclients';
    protected $visible = ['id', 'firstname', 'lastname', 'companyname', 'datecreated'];
    protected $hidden = [
        // 'username',
        // 'password',
        // 'accesshash',
        // 'secure',
        // 'port',
    ];
}