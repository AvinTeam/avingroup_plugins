<?php
namespace AvinGroup\App\Core;

(defined('ABSPATH')) || exit;

class Taxonomies
{

    public function __construct()
    {
        add_action('init', [ $this, 'cat_product' ]);
    }

    public function cat_product()
    {
        $labels = [
            'name'                  => 'دسته محصولات',
            'singular_name'         => 'دسته محصولات',
            'search_items'          => 'جست و جو دسته محصولات',
            'popular_items'         => 'دسته محصولات محبوب',
            'all_items'             => 'دسته محصولات',
            'edit_item'             => 'ویرایش دسته محصول ',
            'update_item'           => 'بروزرسانی دسته محصول ',
            'add_new_item'          => 'افزودن دسته محصول',
            'new_item_name'         => 'نام دسته محصول جدید',
            'add_or_remove_items'   => 'اضافه کردن یا حذف دسته محصول ',
            'choose_from_most_used' => 'از میان دسته محصولات پرکاربرد انتخاب کنید',
            'not_found'             => 'دسته محصول یافت نشد',
            'menu_name'             => 'دسته محصولات',
         ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'public'            => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'cat_product', 'with_front' => false ],
         ];

        register_taxonomy('cat_product', 'products', $args);

    }

}
