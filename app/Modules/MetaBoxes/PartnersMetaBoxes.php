<?php
namespace AvinGroup\App\Modules\MetaBoxes;

use AvinGroup\App\Core\MetaBoxes;

(defined('ABSPATH')) || exit;

class PartnersMetaBoxes extends MetaBoxes
{

    public function __construct()
    {
        add_action('add_meta_boxes', [ $this, 'meta_boxes' ]);
        add_action('save_post', [ $this, 'save' ], 1, 3);
    }

    public function meta_boxes(): void
    {
        add_meta_box(
            'partners_info',
            'اطلاعات همکار',
            [ $this, 'partners_info' ],
            'partners',
            'normal',
            'high'
        );

        add_meta_box(
            'partners_poster_meta',
            'پوستر همکار',
            [ $this, 'render_partners_poster_meta_box' ],
            'partners',
            'side',
            'low'
        );

    }

    public function partners_info($post)
    {
        $colorPrimary   = get_post_meta(get_the_ID(), '_colorPrimary', true);
        $colorSecondary = get_post_meta(get_the_ID(), '_colorSecondary', true);
        $slogan         = get_post_meta(get_the_ID(), '_slogan', true);
        $site           = get_post_meta(get_the_ID(), '_site', true);
        $phone          = get_post_meta(get_the_ID(), '_phone', true);
        $email          = get_post_meta(get_the_ID(), '_email', true);

        view('metaBoxes/partners/info',
            [
                'colorPrimary'   => $colorPrimary,
                'colorSecondary' => $colorSecondary,
                'slogan'         => $slogan,
                'site'           => esc_url($site),
                'phone'          => $phone,
                'email'          => $email,
             ]);

    }

// نمایش فیلد در ادیتور پست
    public function render_partners_poster_meta_box($post)
    {
        $poster_id = get_post_meta($post->ID, '_poster', true);

        view('metaBoxes/partners/poster',
            [
                'poster_id'    => $poster_id,
                'poster_image' => $poster_id ? wp_get_attachment_image($poster_id, 'medium') : '',

             ]);

    }

    public function save($post_id, $post, $updata)
    {
        if ($post->post_type == 'partners') {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            if (! current_user_can('edit_post', $post_id)) {
                return;
            }
            if (isset($_POST[ 'partners' ])) {

                foreach ($_POST[ 'partners' ] as $key => $value) {

                    update_post_meta($post_id, '_' . $key, $value);
                }

            }
        }
    }

}
