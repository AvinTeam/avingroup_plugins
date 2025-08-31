<?php
namespace AvinGroup\App\Core;

use AvinGroup\App\Core\Traits\JDF;

(defined('ABSPATH')) || exit;

class Accesses
{

    use JDF;

    public function __construct()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_action('after_setup_theme', [ $this, 'nav_menu_theme_setup' ]);
        add_filter('get_the_date', [ $this, 'get_the_date' ]);
    }

    public function nav_menu_theme_setup()
    {
        register_nav_menus([
            'main-menu'   => 'فهرست اصلی',
            'footer-menu' => 'فهرست فوتر',
         ]);
    }

    public function get_the_date($the_date)
    {

        return $this->date($the_date);
    }

}
