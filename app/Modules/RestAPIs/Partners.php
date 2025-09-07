<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Partners\PartnersController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class Partners extends RestAPIs
{

    public function __construct()
    {
        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/partners/slug/(?P<slug>[\w-]+)/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'callback' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug' => [
                    'description'       => 'partners slug',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
             ],
         ]
        );
    }
    public function callback(WP_REST_Request $request)
    {

        (new PartnersController)->single($request->get_url_params());

    }

}
