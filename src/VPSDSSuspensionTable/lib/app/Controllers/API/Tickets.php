<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketsStatus;

class Tickets extends API
{
    public function post()
    {
        $serviceid = (int)$this->input['serviceid'];

        $column = trim($this->input['column']);

        if (in_array($column, ['suspensionticket', 'terminationticket'])) {
            $status = (int) $this->input['val'];
            $tstatus = TicketsStatus::updateOrCreate(
                [
                    'serviceid' => $serviceid
                ],
                [$column => $status]
            );
        } elseif (in_array($column, ['suspensionticketdate', 'terminationticketdate'])) {
            $date = $this->input['val'];
            $tstatus = TicketsStatus::updateOrCreate(
                [
                    'serviceid' => $serviceid
                ],
                [$column => $date]
            );
        }
        else
        {
            $tstatus = TicketsStatus::updateOrCreate(
                [
                    'serviceid' => $serviceid
                ],
                [$column => trim($this->input['val'])]
            );
        }
        return ['result' => $tstatus];
    }
}
