<?php
namespace AvinGroup\App\Services\Home;

use AvinGroup\App\Services\Service;

(defined('ABSPATH')) || exit;

class HomeService extends Service
{

    public function index()
    {

        return [
            'header-menu' => '',

         ];

    }

    public function partners()
    {

        $list = [  ];

        $args = [
            'post_type'      => 'partners',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
         ];

        $partners = get_posts($args);

        foreach ($partners as $partner) {

            $list[  ] = [
                'id'             => $partner->ID,
                'title'          => $partner->post_title,
                'image'          => post_image_url($partner->ID),

                'colorPrimary'   => get_post_meta($partner->ID, '_colorPrimary', true),
                'colorSecondary' => get_post_meta($partner->ID, '_colorSecondary', true),
                'slogan'         => get_post_meta($partner->ID, '_slogan', true),
                'site'           => get_post_meta($partner->ID, '_site', true),
                'phone'          => get_post_meta($partner->ID, '_phone', true),
                'email'          => get_post_meta($partner->ID, '_email', true),

             ];
        }

        return $list;

    }

}
