<?php
namespace AvinGroup\App\Modules\Taxonomies;

use AvinGroup\App\Core\Taxonomies;

(defined('ABSPATH')) || exit;

class ServicesTaxonomies extends Taxonomies
{
    public function __construct()
    {
        add_action('init', [ $this, 'services' ]);

        add_action('services_add_form_fields', [ $this, 'add_service_fields' ]);
        add_action('created_services', [ $this, 'save_service_fields' ]);

        add_action('services_edit_form_fields', [ $this, 'edit_service_fields' ]);
        add_action('edited_services', [ $this, 'save_service_fields' ]);

        add_filter('manage_edit-services_columns', [ $this, 'add_service_columns' ]);
        add_filter('manage_services_custom_column', [ $this, 'add_service_column_content' ], 10, 3);
    }

    public function services()
    {
        $labels = [
            'name'                  => 'خدمات همکاران',
            'singular_name'         => 'خدمات همکاران',
            'search_items'          => 'جست و جو خدمات همکاران',
            'popular_items'         => 'خدمات همکاران محبوب',
            'all_items'             => 'خدمات همکاران',
            'edit_item'             => 'ویرایش خدمت همکاران ',
            'update_item'           => 'بروزرسانی خدمت همکاران ',
            'add_new_item'          => 'افزودن خدمت همکاران',
            'new_item_name'         => 'نام خدمت همکاران جدید',
            'add_or_remove_items'   => 'اضافه کردن یا حذف خدمت همکاران ',
            'choose_from_most_used' => 'از میان خدمات همکاران پرکاربرد انتخاب کنید',
            'not_found'             => 'خدمت همکاران یافت نشد',
            'menu_name'             => 'خدمات همکاران',
         ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'public'            => true,
            'show_admin_column' => false,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'services', 'with_front' => false ],
         ];

        register_taxonomy('services', [ 'projects', 'partners' ], $args);
    }

    public function add_service_fields()
    {
        view('components/add_service_fields');

    }

    public function edit_service_fields($term)
    {
        $icon_id  = get_term_meta($term->term_id, 'service_icon', true);
        $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

        $poster_id  = get_term_meta($term->term_id, 'service_poster', true);
        $poster_url = $poster_id ? wp_get_attachment_url($poster_id) : '';

        view('components/edit_service_fields', [

            'icon_id'    => $icon_id,
            'icon_url'   => $icon_url,
            'poster_id'  => $poster_id,
            'poster_url' => $poster_url,

         ]);

    }

    public function save_service_fields($term_id)
    {
        if (isset($_POST[ 'service_icon' ])) {
            update_term_meta($term_id, 'service_icon', sanitize_text_field($_POST[ 'service_icon' ]));
        }

        if (isset($_POST[ 'service_poster' ])) {
            update_term_meta($term_id, 'service_poster', sanitize_text_field($_POST[ 'service_poster' ]));
        }
    }

    public function add_service_columns($columns)
    {
        unset($columns[ 'posts' ]);
        unset($columns[ 'description' ]);
        $columns[ 'icon' ] = 'آیکون';
        return $columns;
    }

    public function add_service_column_content($content, $column_name, $term_id)
    {

        if ($column_name === 'icon') {
            $icon_id = get_term_meta($term_id, 'service_icon', true);
            if ($icon_id) {

                return '<img src="' . wp_get_attachment_image_url($icon_id, 'full') . '"  style="height: 40px;width: 40px;">';
            }
        }

        return $content;
    }
}
