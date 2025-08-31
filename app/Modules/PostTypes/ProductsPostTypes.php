<?php
namespace AvinGroup\App\Modules\PostTypes;

use AvinGroup\App\Core\PostType;
use AvinGroup\App\Models\Products;

(defined('ABSPATH')) || exit;

class ProductsPostTypes extends PostType
{
    public function __construct()
    {
        add_action('init', [ $this, 'products' ]);

        add_filter('manage_content_products_columns', [ $this, 'add_vote_count_column' ]);
        add_filter('manage_products_posts_columns', [ $this, 'add_site_column_title' ]);

    }

    public function products()
    {
        $labels = [
            'name'                  => 'محصول',
            'singular_name'         => 'products',
            'menu_name'             => 'محصولات',
            'name_admin_bar'        => 'محصول',
            'add_new'               => 'اضافه کردن',
            'add_new_item'          => 'اضافه کردن محصول',
            'new_item'              => 'محصول جدید',
            'edit_item'             => 'ویرایش محصول',
            'view_item'             => 'نمایش محصول',
            'all_items'             => 'همه محصولات',
            'search_items'          => 'جست و جو محصول',
            'parent_item_colon'     => 'محصول والد: ',
            'not_found'             => 'محصول یافت نشد',
            'not_found_in_trash'    => 'محصول در سطل زباله یافت نشد',
            'featured_image'        => 'کاور محصول',
            'set_featured_image'    => 'انتخاب تصویر',
            'remove_featured_image' => 'حذف تصویر',
            'use_featured_image'    => 'استفاده به عنوان کاور',
            'archives'              => 'دسته بندی محصول',
            'insert_into_item'      => 'در محصول درج کنید',
            'uploaded_to_this_item' => 'در این محصول درج کنید',
            'filter_items_list'     => 'فیلتر محصول',
            'items_list_navigation' => 'پیمایش محصول',
            'items_list'            => 'لیست محصول',
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
            'menu_icon'          => 'dashicons-hammer',
            'capability_type'    => 'post',
            'supports'           => [ 'title', 'editor', 'author', 'custom-fields', 'thumbnail', 'comments', 'excerpt' ],
            'rewrite'            => [ 'slug' => 'products' ],
            'has_archive'        => true,
         ];

        register_post_type('products', $args);

    }

    public function add_site_column_title($columns)
    {
        $columns[ 'sites' ] = 'تعداد سایت';
        return $columns;
    }

}
