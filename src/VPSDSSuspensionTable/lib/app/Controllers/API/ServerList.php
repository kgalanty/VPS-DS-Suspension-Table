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

        $query = Service::with(['client', 'product', 'ticketsstatus'])
        ->join('vpsds_tickets_status', function($join)
        {
            $join->on('vpsds_tickets_status.serviceid', '=', 'tblhosting.id');
            $join->whereNull('vpsds_tickets_status.deleted_at');
        })
        ->server();

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
            ->skip((int) $page)
            ->take((int) $perpage)
            ->orderBy($sort, $order)
            ->get(['tblhosting.*', 'vpsds_tickets_status.*']);
        
        return ['total' => $total, 'data' => $data];
    }
}