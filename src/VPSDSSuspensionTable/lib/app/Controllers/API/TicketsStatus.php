<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketsStatus as TicketStatusModel;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Classes\TicketDates;
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

                $service = Service::with(['client'])->where('id', $serviceid)->first();

                if(!$service)
                {
                    return ['error' => 'Service not found'];
                }

                $suspensionticketdate = TicketDates::SuspensionTicketDate($service->nextduedate, $service->client->datecreated, 1);
                $terminationticketdate = TicketDates::TerminationTicketDate($service->nextduedate, $service->client->datecreated, 1);

                $ts = TicketStatusModel::create(['serviceid' => $serviceid, $column => $val, 'suspensionticketdate' => $suspensionticketdate, 'terminationticketdate' => $terminationticketdate]);
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
