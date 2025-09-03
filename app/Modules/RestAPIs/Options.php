<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Options\OptionsController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class Options extends RestAPIs
{

    public function __construct()
    {

        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/options/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'callback' ],
            'permission_callback' => '__return_true',
         ]
        );
    }

    public function callback(WP_REST_Request $request)
    {

        (new OptionsController)->index();

    }

}
