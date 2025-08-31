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

    public function save($post_id, $post, $updata)
    {
        if (isset($_POST[ 'project' ])) {

            foreach ($_POST[ 'project' ] as $key => $value) {
                update_post_meta($post_id, '_' . $key, $value);
            }

        }
    }

}
