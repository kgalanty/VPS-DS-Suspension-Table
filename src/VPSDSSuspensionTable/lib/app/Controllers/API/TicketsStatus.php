<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketsStatus as TicketStatusModel;
use Illuminate\Database\Eloquent\Builder;

class TicketsStatus extends API
{
    public function post()
    {
        $serviceid = trim($this->body['serviceid']);
        $column = trim($this->body['column']);
        $val = trim($this->body['val']);

        if ($serviceid && $column && $val) {
            $ts = TicketStatusModel::where('serviceid', $serviceid)->notDeleted()->first();
            if (!$ts) {
                $ts = TicketStatusModel::create(['serviceid' => $serviceid, $column => $val]);
                return ['result' => $ts];
            }

            try {
                $ts->$column = $val;
                $ts->save();
            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
            return ['result' => $ts];
        }
    }
}
