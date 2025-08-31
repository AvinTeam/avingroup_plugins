<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Modules\MetaBoxes\PartnersMetaBoxes;
use AvinGroup\App\Modules\MetaBoxes\ProjectMetaBoxes;
use AvinGroup\App\Modules\PostTypes\ClientsPostTypes;
use AvinGroup\App\Modules\PostTypes\PartnersPostTypes;
use AvinGroup\App\Modules\PostTypes\ProjectPostTypes;

(defined('ABSPATH')) || exit;

class Init
{

    public function __construct()
    {
       new PartnersPostTypes;
       new PartnersMetaBoxes;
       new ClientsPostTypes;
       new ProjectPostTypes;
       new ProjectMetaBoxes;
    }

    

}
