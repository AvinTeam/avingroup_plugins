<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Modules\RestAPIs\Home;
use AvinGroup\App\Modules\RestAPIs\Menu;

(defined('ABSPATH')) || exit;

class RouteAPI
{

    public function __construct()
    {
        new Menu;
        new Home;

    }



















}
