<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Modules\RestAPIs\Clients;
use AvinGroup\App\Modules\RestAPIs\Home;
use AvinGroup\App\Modules\RestAPIs\Options;
use AvinGroup\App\Modules\RestAPIs\Partners;
use AvinGroup\App\Modules\RestAPIs\Projects;
use AvinGroup\App\Modules\RestAPIs\Services;

(defined('ABSPATH')) || exit;

class RouteAPI
{

    public function __construct()
    {
        new Options;
        new Home;
        new Clients;
        new Projects;
        new Services;
        new Partners;

    }

}