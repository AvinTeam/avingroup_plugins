<?php
namespace AvinGroup\App\Modules\PostTypes;

use AvinGroup\App\Core\PostType;

(defined('ABSPATH')) || exit;

class PartnersPostTypes extends PostType
{
     public function __construct()
    {
        add_action('init', [ $this, 'register' ]);

    }

    public function register()
    {
        $labels = [
            'name'                  => 'همکار',
            'singular_name'         => 'partners',
            'menu_name'             => 'همکاران',
            'name_admin_bar'        => 'همکار',
            'add_new'               => 'اضافه کردن',
            'add_new_item'          => 'اضافه کردن همکار',
            'new_item'              => 'همکار جدید',
            'edit_item'             => 'ویرایش همکار',
            'view_item'             => 'نمایش همکار',
            'all_items'             => 'همه همکاران',
            'search_items'          => 'جست و جو همکار',
            'parent_item_colon'     => 'همکار والد: ',
            'not_found'             => 'همکار یافت نشد',
            'not_found_in_trash'    => 'همکار در سطل زباله یافت نشد',
            'featured_image'        => 'کاور همکار',
            'set_featured_image'    => 'انتخاب تصویر',
            'remove_featured_image' => 'حذف تصویر',
            'use_featured_image'    => 'استفاده به عنوان کاور',
            'archives'              => 'دسته بندی همکار',
            'insert_into_item'      => 'در همکار درج کنید',
            'uploaded_to_this_item' => 'در این همکار درج کنید',
            'filter_items_list'     => 'فیلتر همکار',
            'items_list_navigation' => 'پیمایش همکار',
            'items_list'            => 'لیست همکار',
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
            'menu_icon'          => 'dashicons-groups',
            'capability_type'    => 'post',
            'supports'           => [ 'title', 'editor', 'author', 'custom-fields', 'thumbnail' ],
            'rewrite'            => [ 'slug' => 'partners' ],
            'has_archive'        => true,
         ];

        register_post_type('partners', $args);

    }

}
