<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Clients\ClientsController;
use AvinGroup\App\Controllers\Clients\ClientsSingleController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class ClientsSingle extends RestAPIs
{

    public function __construct()
    {

        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/clients/(?P<slug>[\w]+)/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'callback' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug' => [
                    'description'       => 'client slug',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
             ],
         ]
        );
    }
    public function callback(WP_REST_Request $request)
    {

        (new ClientsSingleController)->index($request->get_params());

    }

}
