<?php
namespace AvinGroup\App\Services\Projects;

use AvinGroup\App\Services\Service;
use Exception;

(defined('ABSPATH')) || exit;

class ProjectsSingleService extends Service
{

    public function index($request)
    {

        $project = get_page_by_path(sanitize_text_field($request[ 'slug' ]), OBJECT, 'projects');

        if (! $project) {
            throw new Exception("چنین پروژه ای وجود نداد");
        }

        if ($project->post_status != "publish") {
            throw new Exception("چیزی برای نمایش وجود ندارد");
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

        $partners     = [  ];
        $partners_ids = get_post_meta($project->ID, '_partner', true);
        $partners_ids = is_array($partners_ids) ? array_map('absint', $partners_ids) : [  ];
        foreach (array_unique($partners_ids) as $id) {
            $partners[  ] = [
                'id'             => intval($id),
                'title'          => get_the_title($client_id),
                'image'          => post_image_url(intval($id)),
                'slug'           => get_the_slug(intval($id)),
                'type'           => 'partners',
                'colorPrimary'   => get_post_meta(intval($id), '_colorPrimary', true),
                'colorSecondary' => get_post_meta(intval($id), '_colorSecondary', true),
             ];
        }

        $services = [  ];
        foreach (wp_get_object_terms($project->ID, 'service') as $term) {

            $icon_id = get_term_meta($term->term_id, 'service_icon', true);

            $services[  ] = [
                'id'    => intval($term->term_id),
                'title' => $term->name,
                'image' => $icon_id ? wp_get_attachment_image_url($icon_id, 'full') : '',
                'slug'  => $term->slug,
                'type'  => $term->taxonomy,
             ];
        }

        $links = get_post_meta($project->ID, '_links', true);

        if (is_string($links)) {$links = [  ];}

        $gallery   = [  ];
        $image_ids = get_post_meta($project->ID, '_gallery', true);
        $image_ids = (empty($image_ids)) ? [  ] : explode(',', $image_ids);

        foreach ($image_ids as $image_id) {
            $gallery[  ] = wp_get_attachment_image_url($image_id, 'thumbnail');
        }


        $args = [
            'post_type'      => 'projects',
            'posts_per_page' => 5,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            // 'meta_query'     => [
            //     [
            //         'key'     => '_client',
            //         'value'   => $client_id,
            //         'compare' => '=',
            //      ],
            //  ],
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

        return [
            'id'                 => $project->ID,
            'title'              => $project->post_title,
            'contact'            => $project->post_content,
            'image'              => post_image_url($project->ID),
            'slug'               => get_the_slug(intval($project->ID)),
            'type'               => 'projects',
            'client'             => $client,
            'partners'           => $partners,
            'services'           => $services,
            'links'              => $links,
            'galleryDescription' => get_post_meta($project->ID, '_galleryDescription', true),
            'gallery'            => $gallery,
            'projectList'        => $projectList ?? [  ],
         ];

    }

}
