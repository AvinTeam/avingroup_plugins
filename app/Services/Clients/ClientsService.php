<?php
namespace AvinGroup\App\Services\Clients;

use AvinGroup\App\Services\Service;

(defined('ABSPATH')) || exit;

class ClientsService extends Service
{

    public function index($request)
    {

        $params = $request->get_params();

        $clients = [  ];

        $args = [
            'post_type'      => 'clients',
            'posts_per_page' => $params[ 'per_page' ] ?? 36,
            'paged'          => $params[ 'paged' ] ?? 1,
            'post_status'    => 'publish',

         ];

        $posts = get_posts($args);

        foreach ($posts as $post) {

            $clients[  ] = [
                'id'    => $post->ID,
                'title' => $post->post_title,
                'image' => post_image_url($post->ID),
             ];
        }

        return $clients;
    }

}
