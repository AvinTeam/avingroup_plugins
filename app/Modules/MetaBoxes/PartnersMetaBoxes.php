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

    }

    public function partners_info($post)
    {
        $color  = get_post_meta(get_the_ID(), '_color', true);
        $slogan = get_post_meta(get_the_ID(), '_slogan', true);
        $site   = get_post_meta(get_the_ID(), '_site', true);
        $phone  = get_post_meta(get_the_ID(), '_phone', true);
        $email  = get_post_meta(get_the_ID(), '_email', true);

        view('metaBoxes/partners/info',
            [
                'color'  => $color,
                'slogan' => $slogan,
                'site'   => esc_url($site),
                'phone'  => $phone,
                'email'  => $email,
             ]);

    }

    public function save($post_id, $post, $updata)
    {
        if (isset($_POST[ 'partners' ])) {

            foreach ($_POST[ 'partners' ] as $key => $value) {

                update_post_meta($post_id, '_' . $key, $value);
            }

        }
    }

}
