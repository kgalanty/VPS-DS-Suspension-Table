<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Consts\moduleVersion;

class Addon
{
    public static function config()
    {
        return [
            // Display name for your module
            'name' => 'VPS/DS Suspension Table',
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
        DB::schema()->create('vpsds_tickets_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('serviceid');
            $table->dateTime('suspensionticketdate')->nullable();
            $table->boolean('suspensionticket')->default(false);
            $table->dateTime('terminationticketdate')->nullable();
            $table->boolean('terminationticket')->default(false);
            $table->string('notes')->nullable();
            $table->string('color')->nullable();
            $table->string('deleted_at')->nullable();
            $table->foreign('serviceid')
                ->references('id')->on('tblhosting')
                ->onDelete('cascade');
        });

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
