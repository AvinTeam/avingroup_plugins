<?php
namespace AvinGroup\App\Services\Services;

use AvinGroup\App\Services\Service;
use Exception;

(defined('ABSPATH')) || exit;

class ServicesSingleService extends Service
{

    public function index($request)
    {

        $term = get_term_by('slug', sanitize_text_field($request[ 'slug' ]), 'service');

        if (! $term) {
            throw new Exception("چنین خدمتی ای وجود نداد");
        }

        $icon_id   = get_term_meta($term->term_id, 'service_icon', true);
        $poster_id = get_term_meta($term->term_id, 'service_poster', true);

        $args = [
            'post_type'      => 'projects',
            'posts_per_page' => 5,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'tax_query'      => [
                [
                    'taxonomy' => 'service',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                 ],
             ],

         ];

        $projects = get_posts($args);

        foreach ($projects as $project) {

            foreach (get_post_meta($project->ID, '_partner', true) as $id) {

                $projects_partners[  ] = [
                    'id'             => intval($id),
                    'image'          => post_image_url(intval($id)),
                    'slug'           => get_the_slug(intval($id)),
                    'type'           => 'partners',
                    'colorPrimary'   => get_post_meta(intval($id), '_colorPrimary', true),
                    'colorSecondary' => get_post_meta(intval($id), '_colorSecondary', true),
                 ];

            }

            foreach (wp_get_object_terms($project->ID, 'service') as $term) {

                $services[  ] = [
                    'id'    => intval($term->term_id),
                    'title' => $term->name,
                    'slug'  => $term->slug,
                    'type'  => $term->taxonomy,
                 ];
            }

            $client_id = intval(get_post_meta($project->ID, '_client', true));
            $client    = $client_id ? [
                'id'    => $client_id,
                'title' => get_the_title($client_id),
                'image' => post_image_url(intval($client_id)),
                'slug'  => get_the_slug(intval($client_id)),
                'type'  => 'client',
             ] :
            null;

            $project_list[  ] = [
                'id'       => $project->ID,
                'title'    => $project->post_title,
                'image'    => post_image_url($project->ID),
                'slug'     => $project->post_name,
                'type'     => 'projects',
                'partners' => $projects_partners ?? [  ],
                'client'   => $client,
                'services' => $services ?? [  ],

             ];
        }

        return [
            'id'            => $term->term_id,
            'title'         => $term->name,
            'contact'       => $term->description,
            'icon'          => $icon_id ? wp_get_attachment_image_url($icon_id, 'full') : '',
            'poster'        => $poster_id ? wp_get_attachment_image_url($poster_id, 'full') : '',
            'slug'          => $term->slug,
            'type'          => $term->taxonomy,
            'projects_list' => $project_list ?? [  ],
         ];

        return $clients;
    }

}
