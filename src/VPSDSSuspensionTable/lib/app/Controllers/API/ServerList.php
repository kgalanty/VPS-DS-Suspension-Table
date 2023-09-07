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
            $sort = str_replace(['ticketsstatus'], ['vpsds_tickets_status'], trim($this->input['sort']));
            $order = trim($this->input['orderBy']);

            // $sorting = explode('.', $sort);
            // $table = count($sorting) > 1 ? $sorting[0] : '';
            // $field = count($sorting) > 1 ? $sorting[1] : $sort;
        } else {
            $sort = 'tblhosting.id';
            $order = 'desc';
        }

        $query = Service::with(['client', 'product', 'ticketsstatus'])
            ->server()
            ->join('vpsds_tickets_status', 'vpsds_tickets_status.serviceid', '=', 'tblhosting.id')->select('vpsds_tickets_status.*');
        
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
            ->get();

        return ['total' => $total, 'data' => $data];
    }
}