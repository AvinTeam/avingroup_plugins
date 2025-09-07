<?php
namespace AvinGroup\App\Services\Clients;

use AvinGroup\App\Services\Service;
use Exception;
use WP_Query;

(defined('ABSPATH')) || exit;

class ClientsService extends Service
{

    public function index($params)
    {

        $page     = $params[ 'paged' ] ?? 1;
        $per_page = $params[ 'per_page' ] ?? 36;

        $args = [
            'post_type'      => 'clients',
            'post_status'    => 'publish',
            'posts_per_page' => absint($per_page),
            'paged'          => absint($page),
            'orderby'        => 'date',
            'order'          => 'DESC',
         ];

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $items[  ] = [
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'image' => post_image_url(get_the_ID()),
                    'slug'  => get_the_slug(intval(get_the_ID())),
                    'type'  => 'clients',
                 ];
            }
        }

        return [
            'items'      => $items ?? [  ],
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

        $client = get_page_by_path(sanitize_text_field($request[ 'slug' ]), OBJECT, 'clients');

        $client_id = $client ? $client->ID : null;
        if (is_null($client_id)) {
            throw new Exception("چنین مشتری ای وجود نداد");
        }

        if ($client->post_status != "publish") {
            throw new Exception("چیزی برای نمایش وجود ندارد");
        }

        $clients_args = [
            'post_type'      => 'clients',
            'posts_per_page' => 12,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',

         ];

        $clients_post = get_posts($clients_args);

        foreach ($clients_post as $client) {

            $clientList[  ] = [
                'id'    => $client->ID,
                'title' => $client->post_title,
                'image' => post_image_url($client->ID),
                'slug'  => $client->post_name,
                'type'  => 'clients',
             ];
        }

        $partners_id = [  ];

        $args = [
            'post_type'      => 'projects',
            'posts_per_page' => 10,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'meta_query'     => [
                [
                    'key'     => '_client',
                    'value'   => $client->ID,
                    'compare' => '=',
                 ],
             ],

         ];

        $projects = get_posts($args);

        foreach ($projects as $project) {

            foreach (get_post_meta($project->ID, '_partner', true) as $item) {
                $partners_id[  ] = intval($item);
            }

            $links = get_post_meta($project->ID, '_links', true);

            if (is_string($links)) {$links = [  ];}

            $projectList[  ] = [
                'id'      => $project->ID,
                'title'   => $project->post_title,
                'contact' => $project->post_content,
                'image'   => post_image_url($project->ID),
                'slug'    => $project->post_name,
                'type'    => 'projects',
                'links'   => $links,

             ];
        }

        $partners = [  ];
        foreach (array_unique($partners_id) as $id) {
            $partners[  ] = [
                'id'             => intval($id),
                'title'          => get_the_title($id),
                'image'          => post_image_url(intval($id)),
                'slug'           => get_the_slug(intval($id)),
                'type'           => 'partners',
                'colorPrimary'   => get_post_meta(intval($id), '_colorPrimary', true),
                'colorSecondary' => get_post_meta(intval($id), '_colorSecondary', true),
             ];
        }

        $clients = [
            'id'         => $client->ID,
            'title'      => $client->post_title,
            'contact'    => $client->post_content,
            'image'      => post_image_url($client->ID),
            'slug'       => get_the_slug(intval($client->ID)),
            'type'       => 'clients',
            'partners'   => $partners,
            'projects'   => $projectList ?? [  ],
            'clientList' => $clientList ?? [  ],
         ];

        return $clients;
    }

}
