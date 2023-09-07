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
            $sort = 'id';
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
            ->skip((int) $page)
            ->take((int) $perpage)
            ->get();
        
        if ($order == 'asc') {
            $data = $data->sortBy($sort);
        } elseif ($order == 'desc') {
            $data = $data->sortByDesc($sort);
        }

        return ['total' => $total, 'data' => $data];
    }
}