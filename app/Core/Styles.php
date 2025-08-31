<?php
namespace AvinGroup\App\Core;

(defined('ABSPATH')) || exit;

class Styles
{

    public function __construct()
    {

        add_action('admin_enqueue_scripts', [ $this, 'admin_script' ]);

    }

    public function admin_script()
    {
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_media();

        $this->jalalidatepicker();

        wp_enqueue_style(
            'ag_admin',
            AG_CSS . 'admin.css',
            [ 'jalalidatepicker' ],
            AG_VERSION
        );

        wp_enqueue_script(
            'ag_admin',
            AG_JS . 'admin.js',
            [ 'jquery', 'jalalidatepicker', 'wp-color-picker' ],
            AG_VERSION,
            true
        );

        wp_localize_script(
            'ag_admin',
            'ag_js',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('ajax-nonce'),
             ]
        );

    }

    private function select2()
    {
        wp_register_style(
            'select2',
            AG_VENDOR . 'select2/select2.min.css',
            [  ],
            '4.1.0-rc.0'
        );
        wp_register_script(
            'select2',
            AG_VENDOR . 'select2/select2.min.js',
            [  ],
            '4.1.0-rc.0',
            true
        );

    }

    private function jalalidatepicker()
    {
        wp_register_style(
            'jalalidatepicker',
            AG_VENDOR . 'jalalidatepicker/jalalidatepicker.min.css',
            [  ],
            '0.9.6'
        );
        wp_register_script(
            'jalalidatepicker',
            AG_VENDOR . 'jalalidatepicker/jalalidatepicker.min.js',
            [  ],
            '0.9.6',
            true
        );

    }

}