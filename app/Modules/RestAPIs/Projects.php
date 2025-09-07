<?php
namespace AvinGroup\App\Modules\RestAPIs;

use AvinGroup\App\Controllers\Projects\ProjectsController;
use AvinGroup\App\Core\RestAPIs;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class Projects extends RestAPIs
{

    public function __construct()
    {
        add_action('rest_api_init', [ $this, 'register_routes' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/projects/slug/(?P<slug>[\w-]+)/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'single' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug' => [
                    'description'       => 'projects slug',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
             ],
         ]
        );

        register_rest_route($this->namespace, '/projects/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'index' ],
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

        register_rest_route($this->namespace, '/projects/filters/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'filters' ],
            'permission_callback' => '__return_true',
         ]
        );
    }

    public function index(WP_REST_Request $request)
    {

        (new ProjectsController)->index($request->get_body_params());

    }

    public function single(WP_REST_Request $request)
    {
        (new ProjectsController)->single($request->get_url_params());

    }

    public function filters()
    {
        (new ProjectsController)->filters();
    }

}
