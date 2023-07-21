<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\VPSDSServers;

class ServerList extends API
{
    public function get()
    {
        $query = Groups::with(['pools' => function ($q) {
            $q->orderBy('primary', 'DESC');
        }, 'region', 'productgroups', 'pools.servers.server', 'pools.servers.server.stats'])
            ->get();
        $response = [];
        foreach ($query as $region) {
            foreach ($region->pools as $pool) {
                foreach ($pool->servers as &$server) {

                    $server->server->stats->statsjsoned = json_decode($server->server->stats->statsjson, 1);
                }
            }
            $response[$region->region_id][] = $region;
        }
        return array_values($response);
    }
}
