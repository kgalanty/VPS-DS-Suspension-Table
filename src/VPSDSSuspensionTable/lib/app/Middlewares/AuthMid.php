<?php
namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Middlewares;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Classes\AuthControl;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Consts\AdminGroupsConsts;
//use WHMCS\Module\Addon\LPRServersList\app\Classes\StatsRoleHelper; StatsRoleHelper::getPermID()
trait AuthMid
{
    public function checkPermission()
    {
        if($_SESSION['adminpw'] )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}