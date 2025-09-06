<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Partners\PartnersSingleController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class PartnersSingle extends RestAPIs
{

    public function __construct()
    {

        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/partners/(?P<slug>[\w-]+)/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'callback' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug' => [
                    'description'       => 'partners slug',
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

        (new PartnersSingleController)->index($request->get_params());

    }

}
