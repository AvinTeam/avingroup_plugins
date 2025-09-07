<?php
namespace AvinGroup\App\Services\Projects;

use AvinGroup\App\Services\Service;
use Exception;
use WP_Query;

(defined('ABSPATH')) || exit;

class ProjectsService extends Service
{

    public function index($params)
    {

        $page     = $params[ 'paged' ] ?? 1;
        $per_page = $params[ 'per_page' ] ?? 20;

        $args = [
            'post_type'      => 'projects',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'orderby'        => 'date',
            'order'          => 'DESC',
         ];

        $meta_query = [  ];
        $tax_query  = [  ];

        if (isset($params[ 'partner' ])) {
            $filters[ 'partner' ] = absint($params[ 'partner' ]);
            $meta_query[  ]       = [
                'key'     => '_partner',
                'value'   => '"' . $filters[ 'partner' ] . '"',
                'compare' => 'LIKE',
             ];
        }

        if (isset($params[ 'partner' ]) && isset($params[ 'service' ])) {
            $filters[ 'service' ] = absint($params[ 'service' ]);
            $tax_query[  ]        = [
                'taxonomy' => 'service',
                'field'    => 'term_id',
                'terms'    => $filters[ 'service' ],
             ];
        }

        if (isset($params[ 'client' ])) {
            $filters[ 'client' ] = absint($params[ 'client' ]);
            $meta_query[  ]      = [
                'key'     => '_client',
                'value'   => $filters[ 'client' ],
                'compare' => '=',
             ];
        }

        if (! empty($meta_query)) {
            if (count($meta_query) > 1) {
                $meta_query[ 'relation' ] = 'AND';
            }
            $args[ 'meta_query' ] = $meta_query;
        }

        if (! empty($tax_query)) {
            if (count($tax_query) > 1) {
                $tax_query[ 'relation' ] = 'AND';
            }
            $args[ 'tax_query' ] = $tax_query;
        }
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                foreach (get_post_meta(get_the_ID(), '_partner', true) as $id) {

                    $projects_partners[  ] = [
                        'id'             => intval($id),
                        'image'          => post_image_url(intval($id)),
                        'slug'           => get_the_slug(intval($id)),
                        'type'           => 'partners',
                        'colorPrimary'   => get_post_meta(intval($id), '_colorPrimary', true),
                        'colorSecondary' => get_post_meta(intval($id), '_colorSecondary', true),
                     ];

                }

                foreach (wp_get_object_terms(get_the_ID(), 'service') as $term) {

                    $services[  ] = [
                        'id'    => intval($term->term_id),
                        'title' => $term->name,
                        'slug'  => $term->slug,
                        'type'  => $term->taxonomy,
                     ];
                }

                $client_id = intval(get_post_meta(get_the_ID(), '_client', true));
                $client    = $client_id ? [
                    'id'    => $client_id,
                    'title' => get_the_title($client_id),
                    'image' => post_image_url(intval($client_id)),
                    'slug'  => get_the_slug(intval($client_id)),
                    'type'  => 'client',
                 ] :
                null;

                $items[  ] = [
                    'id'       => get_the_ID(),
                    'title'    => get_the_title(),
                    'image'    => post_image_url(get_the_ID()),
                    'slug'     => get_the_slug(get_the_ID()),
                    'type'     => 'projects',
                    'partners' => $projects_partners ?? [  ],
                    'client'   => $client,
                    'services' => $services ?? [  ],

                 ];

            }
        }

        wp_reset_postdata();

        return [
            'items'      => $items ?? [  ],
            'filters'    => [
                'partner' => $filters[ 'partner' ] ?? 'all',
                'service' => $filters[ 'service' ] ?? 'all',
                'client'  => $filters[ 'client' ] ?? 'all',
             ],
            'pagination' => [
                'current_page' => absint($page),
                'per_page'     => absint($per_page),
                'total_posts'  => absint($query->found_posts),
                'total_pages'  => absint($query->max_num_pages),
                'has_next'     => absint($page) < absint($query->max_num_pages),
                'has_prev'     => absint($page) > 1,
             ],
         ];

    }

    public function single($request)
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
            'orderby'        => 'date',
            'order'          => 'DESC',
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

                $services_partner[  ] = [
                    'id'    => intval($term->term_id),
                    'title' => $term->name,
                    'slug'  => $term->slug,
                    'type'  => $term->taxonomy,
                 ];
            }

            $client_id      = intval(get_post_meta($project->ID, '_client', true));
            $client_partner = $client_id ? [
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
                'client'   => $client_partner,
                'services' => $services_partner ?? [  ],

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

    public function filters()
    {

        $args = [
            'post_type'      => 'partners',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'fields'         => 'ids',
         ];

        $partner_list = get_posts($args);

        foreach ($partner_list as $id) {

            $partners[  ] = [
                'id'    => intval($id),
                'title' => get_the_title($id),
             ];

            foreach (wp_get_object_terms($id, 'service') as $term) {

                $services[ 'partner' . $id ][  ] = [
                    'id'    => intval($term->term_id),
                    'title' => $term->name,
                 ];
            }

        }

        $args = [
            'post_type'      => 'clients',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'fields'         => 'ids',
         ];

        $client_list = get_posts($args);

        foreach ($client_list as $id) {

            $clients[  ] = [
                'id'    => intval($id),
                'title' => get_the_title($id),
             ];
        }

        return [
            'partners' => $partners ?? [  ],
            'services' => $services ?? [  ],
            'clients'  => $clients ?? [  ],
         ];

    }

}