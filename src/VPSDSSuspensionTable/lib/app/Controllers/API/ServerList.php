<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service;

class ServerList extends API
{
    public function get()
    {
        $perpage = 10;
        $page = $this->input['page'] == 1 ? 0 : ($this->input['page'] - 1) * $perpage;

        $query = Service::with(['client', 'product', 'ticketsstatus'])->server()->dueDate($this->input['date']);
        $total = $query->count();
        $data = $query
            ->skip((int)$page)
            ->take((int)$perpage)
            ->orderBy('id', 'desc')
            ->get();
        return ['total' => $total, 'data' => $data];
    }
}
