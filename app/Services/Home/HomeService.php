<?php
namespace AvinGroup\App\Services\Home;

use AvinGroup\App\Services\Service;

(defined('ABSPATH')) || exit;

class HomeService extends Service
{

    public function index()
    {

        return [

         ];

    }

    public function partners()
    {

        $args = [
            'post_type'      => 'partners',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
         ];

        $partners = get_posts($args);

        foreach ($partners as $partner) {

            foreach (wp_get_object_terms($partner->ID, 'partners_services') as $term) {

                $services[  ] = [
                    'id'    => intval($term->term_id),
                    'title' => $term->name,
                    'slug' => $term->slug,
                 ];

            }

            $list[  ] = [
                'id'             => $partner->ID,
                'title'          => $partner->post_title,
                'image'          => post_image_url($partner->ID),
                'slug'           => $partner->post_name,
                'colorPrimary'   => get_post_meta($partner->ID, '_colorPrimary', true),
                'colorSecondary' => get_post_meta($partner->ID, '_colorSecondary', true),
                'slogan'         => get_post_meta($partner->ID, '_slogan', true),
                'site'           => get_post_meta($partner->ID, '_site', true),
                'phone'          => get_post_meta($partner->ID, '_phone', true),
                'email'          => get_post_meta($partner->ID, '_email', true),
                'services'       => $services ?? [  ],

             ];
        }

        return $list ?? [  ];

    }

    public function clients()
    {

        $list = [  ];

        $args = [
            'post_type'      => 'clients',
            'posts_per_page' => 12,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
         ];

        $clients = get_posts($args);

        foreach ($clients as $client) {

            $list[  ] = [
                'id'    => $client->ID,
                'title' => $client->post_title,
                'image' => post_image_url($client->ID),
                'slug'  => $client->post_name,

             ];
        }

        return $list;

    }

    public function projects()
    {

        $list = [  ];

        $args = [
            'post_type'      => 'projects',
            'posts_per_page' => 10,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
         ];

        $projects = get_posts($args);

        foreach ($projects as $project) {

            $partners = [  ];
            foreach (get_post_meta($project->ID, '_partner', true) as $item) {
                $partners[  ] = [
                    'id'    => intval($item),
                    'image' => post_image_url(intval($item)),
                    'slug'  => get_the_slug(intval($item)),
                 ];
            }

            $client_id = intval(get_post_meta($project->ID, '_client', true));
            $services  = [  ];

            foreach (wp_get_object_terms($project->ID, 'partners_services') as $term) {

                $services[  ] = [
                    'id'   => intval($term->term_id),
                    'name' => $term->name,
                    'slug' => $term->slug,
                 ];
            }

            $list[  ] = [
                'id'       => $project->ID,
                'title'    => $project->post_title,
                'image'    => post_image_url($project->ID),
                'slug'     => $project->post_name,
                'partners' => $partners,
                'client'   => [
                    'title' => get_the_title($client_id),
                    'image' => post_image_url($client_id),
                 ],
                'services' => $services,
             ];
        }

        return $list;

    }

}
