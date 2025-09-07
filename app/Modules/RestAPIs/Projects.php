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

        register_rest_route($this->namespace, '/projects/?', [
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
        register_rest_route($this->namespace, '/projects/filters/?', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'filters' ],
            'permission_callback' => '__return_true',
         ]
        );
    }
    public function single(WP_REST_Request $request)
    {
        (new ProjectsController)->single($request->get_params());

    }

    public function filters()
    {
        (new ProjectsController)->filters();}

}
