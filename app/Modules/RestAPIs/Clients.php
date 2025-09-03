<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Clients\ClientsController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class Clients extends RestAPIs
{

    public function __construct()
    {

        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/clients/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'callback' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'per_page' => [
                    'description'       => 'per page',
                    'required'          => false,
                    'type'              => 'integer',
                    'sanitize_callback' => 'absint',
                 ],
                'paged'    => [
                    'description'       => 'paged',
                    'required'          => false,
                    'type'              => 'integer',
                    'sanitize_callback' => 'absint',
                 ],
             ],
         ]
        );
    }

    public function callback(WP_REST_Request $request)
    {

        (new ClientsController)->index($request);

    }

}
