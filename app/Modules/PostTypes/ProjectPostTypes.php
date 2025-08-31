<?php
namespace AvinGroup\App\Modules\PostTypes;

use AvinGroup\App\Core\PostType;

(defined('ABSPATH')) || exit;

class ProjectPostTypes extends PostType
{
    public function __construct()
    {
        add_action('init', [ $this, 'register' ]);

    }

    public function register()
    {
        $labels = [
            'name'                  => 'پروژه',
            'singular_name'         => 'Projects',
            'menu_name'             => 'پروژه ها',
            'name_admin_bar'        => 'پروژه',
            'add_new'               => 'اضافه کردن',
            'add_new_item'          => 'اضافه کردن پروژه',
            'new_item'              => 'پروژه جدید',
            'edit_item'             => 'ویرایش پروژه',
            'view_item'             => 'نمایش پروژه',
            'all_items'             => 'همه پروژه ها',
            'search_items'          => 'جست و جو پروژه',
            'parent_item_colon'     => 'پروژه والد: ',
            'not_found'             => 'پروژه یافت نشد',
            'not_found_in_trash'    => 'پروژه در سطل زباله یافت نشد',
            'featured_image'        => 'کاور پروژه',
            'set_featured_image'    => 'انتخاب تصویر',
            'remove_featured_image' => 'حذف تصویر',
            'use_featured_image'    => 'استفاده به عنوان کاور',
            'archives'              => 'دسته بندی پروژه',
            'insert_into_item'      => 'در پروژه درج کنید',
            'uploaded_to_this_item' => 'در این پروژه درج کنید',
            'filter_items_list'     => 'فیلتر پروژه',
            'items_list_navigation' => 'پیمایش پروژه',
            'items_list'            => 'لیست پروژه',
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
            'menu_icon'          => 'dashicons-art',
            'capability_type'    => 'post',
            'supports'           => [ 'title', 'editor', 'author', 'custom-fields', 'thumbnail' ],
            'rewrite'            => [ 'slug' => 'Projects' ],
            'has_archive'        => true,
         ];

        register_post_type('Projects', $args);

    }



}
