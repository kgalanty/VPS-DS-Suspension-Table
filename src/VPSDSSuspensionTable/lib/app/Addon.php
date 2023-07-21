<?php

namespace WHMCS\Module\Addon\LPRServersList\app;

use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\LPRServersList\app\Consts\moduleVersion;

class Addon
{
    public static function config()
    {
        return [
            // Display name for your module
            'name' => 'LPR Servers List',
            // Description displayed within the admin interface
            'description' => '',
            // Module author name
            'author' => 'TMD',
            'version' => moduleVersion::VERSION,
        ];
    }
    public static function activate()
    {
        /**
         * Database Statements here
         */
        return [
            'status' => 'success',
            'description' => 'The module has been successfuly activated.',
        ];
    }
    public static function deactivate()
    {
        return [
            'status' => 'success',
            'description' => 'The module has been successfuly deactivated.',
        ];
    }
    public static function upgrade()
    {
    }
}
