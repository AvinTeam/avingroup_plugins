<?php
namespace AvinGroup\App\Modules\PostTypes;

use AvinGroup\App\Core\PostType;

(defined('ABSPATH')) || exit;

class ClientsPostTypes extends PostType
{
    public function __construct()
    {
        add_action('init', [ $this, 'register' ]);

    }

    public function register()
    {
        $labels = [
            'name'                  => 'مشتری',
            'singular_name'         => 'clients',
            'menu_name'             => 'مشتری ها',
            'name_admin_bar'        => 'مشتری',
            'add_new'               => 'اضافه کردن',
            'add_new_item'          => 'اضافه کردن مشتری',
            'new_item'              => 'مشتری جدید',
            'edit_item'             => 'ویرایش مشتری',
            'view_item'             => 'نمایش مشتری',
            'all_items'             => 'همه مشتری ها',
            'search_items'          => 'جست و جو مشتری',
            'parent_item_colon'     => 'مشتری والد: ',
            'not_found'             => 'مشتری یافت نشد',
            'not_found_in_trash'    => 'مشتری در سطل زباله یافت نشد',
            'featured_image'        => 'کاور مشتری',
            'set_featured_image'    => 'انتخاب تصویر',
            'remove_featured_image' => 'حذف تصویر',
            'use_featured_image'    => 'استفاده به عنوان کاور',
            'archives'              => 'دسته بندی مشتری',
            'insert_into_item'      => 'در مشتری درج کنید',
            'uploaded_to_this_item' => 'در این مشتری درج کنید',
            'filter_items_list'     => 'فیلتر مشتری',
            'items_list_navigation' => 'پیمایش مشتری',
            'items_list'            => 'لیست مشتری',
         ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'hierarchical'       => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'      => 5,
            'query_var'          => true,
            'menu_icon'          => 'dashicons-businessman',
            'capability_type'    => 'post',
            'supports'           => [ 'title', 'editor', 'author', 'custom-fields', 'thumbnail' ],
            'rewrite'            => [ 'slug' => 'clients' ],
            'has_archive'        => true,
         ];

        register_post_type('clients', $args);

    }

}