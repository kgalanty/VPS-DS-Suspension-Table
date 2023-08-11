<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ServerList extends API
{
    public function get()
    {
        $perpage = 20;
        $page = $this->input['page'] == 1 ? 0 : ($this->input['page'] - 1) * $perpage;

        $query = Service::with(['client', 'product', 'ticketsstatus'])->server();

        if ($this->input['withtickets']) {
            $query = $query->whereHas('ticketsstatus', function (Builder $query) {
                $query->whereNull('deleted_at');
            });
        } else {
            $query = $query->doesntHave('ticketsstatus')
                ->orWhereHas('ticketsstatus', function (Builder $query) {
                    $query->whereNull('deleted_at');
                });
        }

        if ($this->input['date']) {
            $query = $query->dueDate($this->input['date']);
        }
        $total = $query->count();
        $data = $query
            ->skip((int)$page)
            ->take((int)$perpage)
            ->orderBy('id', 'desc')
            ->get();
        return ['total' => $total, 'data' => $data];
    }
}
