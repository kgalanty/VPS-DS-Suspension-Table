<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Controllers;
use WHMCS\Module\Addon\VPSDSSuspensionTable\Controller;

/**
 * Admin Area Controller
 */
class Home extends Controller
{
     /**
     * Index action.
     *
     * @param array $vars Module configuration parameters
     *
     * @return array
     */
    public function __construct()
    {
         //parent::__construct();
    }
    public function index($vars)
    {
        
        //$vars['somevar'] = 'somevalue';
        return $vars;
    }
}