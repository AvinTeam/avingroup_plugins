<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Models\Sites;
use WP_Error;
use WP_REST_Request;

(defined('ABSPATH')) || exit;

class RestAPI
{

    private $namespace;

    public function __construct()
    {
        $this->namespace = 'sazo/v1';

        add_action('rest_api_init', [ $this, 'register_routes' ]);
        add_filter('rest_authentication_errors', [ $this, 'disable_default_endpoints' ]);
    }

    public function register_routes()
    {

        register_rest_route($this->namespace, '/product/?', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'product' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug'    => [
                    'description'       => 'product slug',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'type'    => [
                    'description'       => 'product type',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'version' => [
                    'description'       => 'product version',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'status'  => [
                    'description'       => 'product status',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'url'     => [
                    'description'       => 'site url',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'get_domain',
                 ],
                'title'   => [
                    'description'       => 'site title',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'email'   => [
                    'description'       => 'site email',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_email',
                 ],
                'mobile'  => [
                    'description'       => 'admin site mobile',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_phone',
                 ],

             ],
         ]
        );

        register_rest_route($this->namespace, '/product/?', [
            'methods'             => 'DELETE',
            'callback'            => [ $this, 'deleteProduct' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'slug' => [
                    'description'       => 'product slug',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'url'  => [
                    'description'       => 'site url',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'get_domain',
                 ],
             ],

         ]
        );

        register_rest_route($this->namespace, '/site/?', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'addSite' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'url'    => [
                    'description'       => 'site url',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'get_domain',
                 ],
                'title'  => [
                    'description'       => 'site title',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                 ],
                'email'  => [
                    'description'       => 'site email',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_email',
                 ],
                'mobile' => [
                    'description'       => 'admin site mobile',
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_phone',
                 ],

             ],
         ]
        );

        register_rest_route($this->namespace, '/site/?', [
            'methods'             => 'DELETE',
            'callback'            => [ $this, 'deleteSite' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'url' => [
                    'description'       => 'site url',
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'get_domain',
                 ],
             ],

         ]
        );

    }

    // public function product(WP_REST_Request $request)
    // {

    //     $params = $request->get_params();

    //     $product = get_page_by_path(sanitize_text_field($params[ 'slug' ]), OBJECT, 'products');

    //     $product_id = $product ? $product->ID : null;

    //     if (is_null($product_id)) {
    //         return rest_ensure_response([
    //             'success' => false,
    //             'message' => 'چنین محصولی وجود ندارد',
    //          ]);
    //     }

    //     $site = Sites::customFind('url', get_domain($params[ 'url' ]));

    //     if (is_null($site)) {

    //         $site = Sites::create([
    //             'url'    => get_domain($params[ 'url' ]),
    //             'title'  => sanitize_text_field($params[ 'title' ]),
    //             'email'  => sanitize_email($params[ 'email' ]),
    //             'mobile' => sanitize_phone($params[ 'mobile' ]),
    //          ]);
    //     } else {
    //         $site->update([
    //             'title'  => sanitize_text_field($params[ 'title' ]),
    //             'email'  => sanitize_email($params[ 'email' ]),
    //             'mobile' => sanitize_phone($params[ 'mobile' ]),
    //          ]);
    //     }

    //     $site->attachProduct($product_id, [
    //         'type'    => sanitize_text_field($params[ 'type' ]),
    //         'version' => sanitize_text_field($params[ 'version' ]),
    //         'status'  => sanitize_text_field($params[ 'status' ]),
    //      ]);

    //     return rest_ensure_response([
    //         'success' => true,
    //         'message' => 'با موفقیت انحام شد',
    //      ]);

    // }

    // public function deleteProduct(WP_REST_Request $request)
    // {

    //     $params = $request->get_params();

    //     $product = get_page_by_path(sanitize_text_field($params[ 'slug' ]), OBJECT, 'products');

    //     $product_id = $product ? $product->ID : null;

    //     if (is_null($product_id)) {
    //         return rest_ensure_response([
    //             'success' => false,
    //             'message' => 'چنین محصولی وجود ندارد',
    //          ]);
    //     }

    //     $site = Sites::customFind('url', get_domain($params[ 'url' ]));

    //     if (is_null($site)) {

    //         return rest_ensure_response([
    //             'success' => false,
    //             'message' => 'چنین سایتی وجود ندارد',
    //          ]);
    //     }

    //     $site->deleteAttachProduct($product_id);

    //     return rest_ensure_response([
    //         'success' => true,
    //         'message' => 'با موفقیت انحام شد',
    //      ]);

    // }

    // public function addSite(WP_REST_Request $request)
    // {

    //     $params = $request->get_params();

    //     $site = Sites::customFind('url', get_domain($params[ 'url' ]));

    //     if (is_null($site)) {

    //         $site = Sites::create([
    //             'url'    => get_domain($params[ 'url' ]),
    //             'title'  => sanitize_text_field($params[ 'title' ]),
    //             'email'  => sanitize_email($params[ 'email' ]),
    //             'mobile' => sanitize_phone($params[ 'mobile' ]),
    //          ]);
    //     } else {
    //         $site->update([
    //             'title'  => sanitize_text_field($params[ 'title' ]),
    //             'email'  => sanitize_email($params[ 'email' ]),
    //             'mobile' => sanitize_phone($params[ 'mobile' ]),
    //          ]);
    //     }
    //     return rest_ensure_response([
    //         'success' => true,
    //         'message' => 'ok',
    //      ]);

    // }

    // public function deleteSite(WP_REST_Request $request)
    // {

    //     $params = $request->get_params();

    //     $site = Sites::customFind('url', get_domain($params[ 'url' ]));

    //     if (is_null($site)) {

    //         return rest_ensure_response([
    //             'success' => false,
    //             'message' => 'چنین سایتی وجود ندارد',
    //          ]);
    //     }

    //     $site->delete();

    //     return rest_ensure_response([
    //         'success' => true,
    //         'message' => 'با موفقیت انحام شد',
    //      ]);

    // }

    // public function disable_default_endpoints($access)
    // {
    //     if (! is_user_logged_in() || ! current_user_can('manage_options')) {
    //         $request_uri = $_SERVER[ 'REQUEST_URI' ];

    //         // غیرفعال کردن اندپوینت‌های پیش‌فرض وردپرس
    //         if (strpos($request_uri, '/wp-json/wp/v2/') !== false) {
    //             return new WP_Error(
    //                 'rest_disabled',
    //                 'اندپوینت‌های پیش‌فرض غیرفعال شده‌اند',
    //                 [ 'status' => 403 ]
    //             );
    //         }
    //     }

    //     return $access;
    // }

}