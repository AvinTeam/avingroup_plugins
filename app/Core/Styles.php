<?php
namespace AvinGroup\App\Core;

(defined('ABSPATH')) || exit;

class Styles
{

    private $style_dep      = [  ];
    private $javascript_dep = [ 'jquery' , 'wp-color-picker'];

    public function __construct()
    {

        add_action('admin_enqueue_scripts', [ $this, 'admin_script' ]);

    }

    public function admin_script()
    {
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_media();

        $this->jalalidatepicker();
        $this->select2();

        wp_enqueue_style(
            'ag_admin',
            AG_CSS . 'admin.css',
            $this->style_dep,
            AG_VERSION
        );

        wp_enqueue_script(
            'ag_admin',
            AG_JS . 'admin.js',
            $this->javascript_dep,
            AG_VERSION,
            true
        );

        wp_localize_script(
            'ag_admin',
            'ag_js',
            [
                'ajaxurl'  => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('ajax-nonce'),
                'linkList' => config('app.linkList', [  ]),
                'socials' => config('app.socials', [  ]),
             ]
        );

    }

    private function select2()
    {

        $this->style_dep[  ] = $this->javascript_dep[  ] = 'select2';

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

        $this->style_dep[  ] = $this->javascript_dep[  ] = 'jalalidatepicker';

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