<?php
namespace AvinGroup\App\Services\Partners;

use AvinGroup\App\Services\Service;
use Exception;

(defined('ABSPATH')) || exit;

class PartnersSingleService extends Service
{

    public function index($request)
    {

        $partners = get_page_by_path(sanitize_text_field($request[ 'slug' ]), OBJECT, 'partners');

        if (! $partners) {
            throw new Exception("چنین همکاری وجود نداد");
        }

        if ($partners->post_status != "publish") {
            throw new Exception("چیزی برای نمایش وجود ندارد");
        }

        $poster_id = get_post_meta($partners->ID, '_poster', true);

        foreach (wp_get_object_terms($partners->ID, 'service') as $term) {

            $icon_id = get_term_meta($term->term_id, 'service_icon', true);

            $services[  ] = [
                'id'    => intval($term->term_id),
                'title' => $term->name,
                'image' => $icon_id ? wp_get_attachment_image_url($icon_id, 'full') : '',
                'slug'  => $term->slug,
                'type'  => $term->taxonomy,
             ];
        }

        $args = [
            'post_type'      => 'projects',
            'posts_per_page' => 5,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'meta_query'     => [
                [
                    'key'     => '_partner',
                    'value'   => '"' . $partners->ID . '"',
                    'compare' => 'LIKE',
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

            $projectList[  ] = [
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

        unset($args[ 'posts_per_page' ]);
        $args[ 'fields' ] = 'ids';

        $client_post = get_posts($args);

        foreach ($client_post as $id) {
            $client_id = intval(get_post_meta($id, '_client', true));

            if ($client_id) {

                $clientList[  ] = [
                    'id'    => $client_id,
                    'title' => get_the_title($client_id),
                    'image' => post_image_url(intval($client_id)),
                    'slug'  => get_the_slug(intval($client_id)),
                    'type'  => 'client',
                 ];
            }
        }


        return [
            'id'                 => $partners->ID,
            'title'              => $partners->post_title,
            'contact'            => $partners->post_content,
            'image'              => post_image_url($partners->ID),
            'slug'               => get_the_slug(intval($partners->ID)),
            'colorPrimary'       => get_post_meta($partners->ID, '_colorPrimary', true),
            'colorSecondary'     => get_post_meta($partners->ID, '_colorSecondary', true),
            'slogan'             => get_post_meta($partners->ID, '_slogan', true),
            'site'               => get_post_meta($partners->ID, '_site', true),
            'phone'              => get_post_meta($partners->ID, '_phone', true),
            'email'              => get_post_meta($partners->ID, '_email', true),
            'serviceDescription' => get_post_meta($partners->ID, '_serviceDescription', true),
            'poster'             => $poster_id ? wp_get_attachment_image_url($poster_id, 'medium') : '',
            'services'           => $services ?? [  ],
            'project_list'       => $projectList ?? [  ],
            'clientList'         => $clientList ?? [  ],
         ];

    }

}
