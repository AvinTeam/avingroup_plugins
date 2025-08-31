<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Modules\PostTypes\ProductsPostTypes;

(defined('ABSPATH')) || exit;

class Init
{

    public function __construct()
    {
       new ProductsPostTypes;
    }

    

}
