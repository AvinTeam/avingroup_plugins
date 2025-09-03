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
            'partners_services',
            'خدمات همکار',
            [ $this, 'partners_services' ],
            'partners',
            'normal',
            'high'
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

    public function partners_services($post)
    {

        $servicesId = intval(get_post_meta(get_the_ID(), '_servicesId', true));

        if ($servicesId) {

            $terms = [  ];

            foreach (get_term_children($servicesId, 'services') as $term_id) {

                $icon_id  = get_term_meta($term_id, 'service_icon', true);
                $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';
                $term     = get_term($term_id, 'services');

                $terms[  ] = [
                    'id'    => $term_id,
                    'title' => $term->name,
                    'icon'  => $icon_url,

                 ];

            }

            view('metaBoxes/partners/services',
                [
                    'terms' => $terms,
                 ]);
        }

    }

    public function save($post_id, $post, $updata)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }
        if (isset($_POST[ 'partners' ])) {

            $slug = $post->post_name;
            $name = get_the_title();

            $servicesId = intval(get_post_meta(get_the_ID(), '_servicesId', true));

            if (! $servicesId) {

                $term = term_exists($slug, 'services');

                if (! $term) {
                    $term = wp_insert_term($name, 'services', [
                        'slug' => $slug,
                     ]);
                }

                $servicesId = absint($term[ 'term_id' ]);

                update_post_meta(get_the_ID(), '_servicesId', $servicesId);

            } else {
                wp_update_term($servicesId, 'services', [
                    'name' => $name,
                    'slug' => $slug,
                 ]);
            }

            foreach ($_POST[ 'partners' ] as $key => $value) {

                update_post_meta($post_id, '_' . $key, $value);
            }

        }
    }

}
