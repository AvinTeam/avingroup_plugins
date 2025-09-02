<?php
namespace AvinGroup\App\Modules\MetaBoxes;

use AvinGroup\App\Core\MetaBoxes;

(defined('ABSPATH')) || exit;

class ProjectMetaBoxes extends MetaBoxes
{

    public function __construct()
    {
        add_action('add_meta_boxes', [ $this, 'meta_boxes' ]);
        add_action('save_post', [ $this, 'save' ], 1, 3);
    }

    public function meta_boxes(): void
    {

        add_meta_box(
            'gallery',
            'گالری',
            [ $this, 'gallery' ],
            'projects',
            'normal',
            'high'
        );
        add_meta_box(
            'links',
            'لینک ها',
            [ $this, 'links' ],
            'projects',
            'normal',
            'high'
        );

        add_meta_box(
            'client',
            'مشتری',
            [ $this, 'client' ],
            'projects',
            'side',
        );

        add_meta_box(
            'partners',
            'مجریان',
            [ $this, 'partners' ],
            'projects',
            'side',
        );

    }

    public function gallery($post)
    {

        $gallery = get_post_meta(get_the_ID(), '_gallery', true);

        $galleryDescription = get_post_meta(get_the_ID(), '_galleryDescription', true);

        view('metaBoxes/project/gallery',
            [
                'gallery'            => $gallery,
                'image_ids'          => (empty($gallery)) ? [  ] : explode(',', $gallery),
                'galleryDescription' => $galleryDescription,
             ]);

    }

    public function links($post)
    {

        $links = get_post_meta(get_the_ID(), '_links', true);

        view('metaBoxes/project/links',
            [
                'links' => $links,
             ]);

    }

    public function client($post)
    {

        $isCorrect = intval(get_post_meta(get_the_ID(), '_client', true));

        $clients = [  ];

        $args = [
            'post_type'      => 'clients',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
         ];

        $posts = get_posts($args);

        foreach ($posts as $post) {

            $clients[  ] = [
                'id'    => $post->ID,
                'title' => $post->post_title,
             ];
        }

        view('metaBoxes/project/clients',
            [
                'clients'   => $clients,
                'isCorrect' => $isCorrect,
             ]);

    }

    public function partners($post)
    {

        $isCorrect = get_post_meta(get_the_ID(), '_partner', true);
        $isCorrect = array_map('absint', $isCorrect);

        $partners = [  ];

        $args = [
            'post_type'      => 'partners',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
         ];

        $posts = get_posts($args);

        foreach ($posts as $post) {

            $partners[  ] = [
                'id'    => $post->ID,
                'title' => $post->post_title,
             ];
        }

        view('metaBoxes/project/partners',
            [
                'partners'  => $partners,
                'isCorrect' => $isCorrect,
             ]);

    }

    public function save($post_id, $post, $updata)
    {
        if (isset($_POST[ 'project' ])) {

            foreach ($_POST[ 'project' ] as $key => $value) {

                if ($key == 'links') {
                    $value = array_filter($value, function ($item) {
                        return ! empty($item[ 'link' ]);
                    });
                }

                update_post_meta($post_id, '_' . $key, $value);
            }

            if (! isset($_POST[ 'project' ][ 'partner' ])) {
                update_post_meta($post_id, '_partner', [  ]);
            }
        }
    }

}
