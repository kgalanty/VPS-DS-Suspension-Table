<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;

use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers\API;
use WHMCS\Database\Capsule as DB;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketTpl;

class Tickets extends API
{

    public function post()
    {
        if ($this->input['action'] === 'delete') {
            $id = (int)$this->body['id'];
            if (!$id) {
                return ['error' => 'No id received'];
            }

            $tpl = TicketTpl::where('id', $id)->delete();
            //$tpl = 1;
            if ($tpl) {
                return ['result' => $tpl];
            } else {
                return ['error' => 'Cannot found template with given id'];
            }
        }

        $name = trim($this->body['name']);
        $title = trim($this->body['title']);
        $content = trim($this->body['content']);
        $id = (int)$this->body['id'];

        if (!$name || !$title || !$content) {
            return ['error' => 'Not all required fields were filled'];
        }

        if ($id) {
            $ticketstpl = TicketTpl::find($id);
            $ticketstpl->name = $name;
            $ticketstpl->title = $title;
            $ticketstpl->content = $content;
            $ticketstpl->save();
        } else {
            $ticketstpl = TicketTpl::create(['name' => $name, 'title' => $title, 'content' => $content]);
        }

        return ['result' => $ticketstpl];
    }

    public function get()
    {
        if ($this->input['id']) {
            $tpl = TicketTpl::find((int)$this->input['id']);
            return ['data' => $tpl];
        }
        
        $perpage = 20;
        $page = $this->input['page'] == 1 ? 0 : ($this->input['page'] - 1) * $perpage;

        $total = TicketTpl::count();
        $data = TicketTpl::skip((int)$page)
            ->take((int)$perpage)
            ->orderBy('name', 'asc')
            ->get();
        return ['total' => $total, 'data' => $data];
    }
}
