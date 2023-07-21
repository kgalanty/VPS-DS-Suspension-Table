<?php

use WHMCS\Module\Addon\VPSDSSuspensionTable\Dispatcher;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Addon;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function VPSDSSuspensionTable_config()
{
    return Addon::config();
}
function VPSDSSuspensionTable_output($vars)
{
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    $ctrl = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'home';
    $dispatcher = new Dispatcher();
    $response = $dispatcher->dispatch($ctrl, $action, $vars);
    echo $response;
    exit;
}

function VPSDSSuspensionTable_activate()
{
    return Addon::activate();
}
function VPSDSSuspensionTable_deactivate()
{
    return Addon::deactivate();
}
function VPSDSSuspensionTable_upgrade()
{
    return Addon::upgrade();
}