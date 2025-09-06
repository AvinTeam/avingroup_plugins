<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Modules\RestAPIs\Clients;
use AvinGroup\App\Modules\RestAPIs\ClientsSingle;
use AvinGroup\App\Modules\RestAPIs\Home;
use AvinGroup\App\Modules\RestAPIs\Options;
use AvinGroup\App\Modules\RestAPIs\PartnersSingle;
use AvinGroup\App\Modules\RestAPIs\ProjectsSingle;
use AvinGroup\App\Modules\RestAPIs\ServicesSingle;

(defined('ABSPATH')) || exit;

class RouteAPI
{

    public function __construct()
    {
        new Options;
        new Home;
        new Clients;
        new ClientsSingle;
        new ProjectsSingle;
        new ServicesSingle;
        new PartnersSingle;

    }

}
