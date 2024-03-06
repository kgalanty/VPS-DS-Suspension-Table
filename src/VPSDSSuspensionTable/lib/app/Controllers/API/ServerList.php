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

        $query = Service::leftJoin('tblproducts as p', 'p.id', '=', 'tblhosting.packageid');

        if ($this->input['withtickets']) {
            $query = $query->has('ticketsstatus');
        } else {
            $query = $query->doesnthave('ticketsstatus');
        }

        if ($this->input['date']) {
            $query = $query->dueDate($this->input['date']);
        }
        $total = $query->count();

        $query = $query->with(['ticketsstatus'])
            ->leftJoin('vpsds_tickets_status as v', function ($join) {
                $join->on('v.serviceid', '=', 'tblhosting.id');
                $join->whereNull('v.deleted_at');
            })->leftJoin('tblclients as c', 'c.id', '=', 'tblhosting.userid')
          ;


        if ($this->input['search'] != '') {
            //Rewrite date from format 09/08 to (2023-)08-09 as stored in DB
            $date = strpos($this->input['search'], '/') !== false ? implode("-", array_reverse(explode("/", $this->input['search']))) : $this->input['search'];

            $query = $query
                ->where(function($query) use ($date)
                {
                    $query->where('tblhosting.domain', 'LIKE', '%' . $this->input['search'] . '%')
                    ->orWhere('c.firstname', 'LIKE', '%' . $this->input['search'] . '%')
                    ->orWhere('c.lastname', 'LIKE', '%' . $this->input['search'] . '%')
                    ->orWhere('c.companyname', 'LIKE', '%' . $this->input['search'] . '%')
                    ->orWhere('v.notes','LIKE', '%' . $this->input['search'] .'%')
                    ->orWhere('v.suspensionticketdate','LIKE', '%' . $date .'%')
                    ->orWhere('v.terminationticketdate','LIKE', '%' . $date .'%');
                });
            $total = $query->count();
        }

        $data = $query->skip((int) $page)
            ->take((int) $perpage)
            ->orderBy($sort, $order)
            ->select([
                'p.name AS product_name',
                'c.firstname AS client_firstname',
                'c.lastname AS client_lastname',
                'c.datecreated AS client_datecreated',
                'tblhosting.*',
                'v.id AS vps_status',
                'v.suspensionticketdate',
                'v.suspensionticket',
                'v.terminationticketdate',
                'v.terminationticket',
                'v.notes',
                'v.color'
            ])
            ->get();

        return ['total' => $total, 'data' => $data];
    }
}