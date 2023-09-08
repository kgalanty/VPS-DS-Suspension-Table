<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service;

class ServerList extends API
{
    public function get()
    {
        $perpage = 20;
        $page = $this->input['page'] == 1 ? 0 : ($this->input['page'] - 1) * $perpage;

        if ($this->input['sort'] && $this->input['orderBy']) {
            $sort = trim($this->input['sort']);
            $order = trim($this->input['orderBy']);
        } else {
            $sort = 'tblhosting.id';
            $order = 'desc';
        }

        $query = Service::with(['client', 'product', 'ticketsstatus'])->server();

        if ($this->input['withtickets']) {
            $query = $query->has('ticketsstatus');
        } else {
            $query = $query->doesnthave('ticketsstatus');
        }

        if ($this->input['date']) {
            $query = $query->dueDate($this->input['date']);
        }
        $total = $query->count();

        $data = $query
        ->join('vpsds_tickets_status as v', function($join)
        {
            $join->on('v.serviceid', '=', 'tblhosting.id');
            $join->whereNull('v.deleted_at');
        })
            ->skip((int) $page)
            ->take((int) $perpage)
            ->orderBy($sort, $order)
            ->select(['tblhosting.*', 'v.id AS vps_status','v.suspensionticketdate'
            ,'v.suspensionticket','v.terminationticketdate', 'v.terminationticket','v.notes','v.color'])
            ->get();
        
        return ['total' => $total, 'data' => $data];
    }
}