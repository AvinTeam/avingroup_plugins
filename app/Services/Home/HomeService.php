<?php
namespace AvinGroup\App\Services\Home;

use AvinGroup\App\Services\Service;

(defined('ABSPATH')) || exit;

class HomeService extends Service
{

    public function index()
    {

        return [
            'header-menu' => $this->get_menu_by_location('main-menu'),

         ];

    }

    // menu
    public function get_menu_by_location($location)
    {

        $menu_locations = get_nav_menu_locations();

        if (! isset($menu_locations[ $location ])) {

            throw new \Exception('منویی در این موقعیت یافت نشد', 404);
        }

        $menu_items = wp_get_nav_menu_items($menu_locations[ $location ]);

        if (empty($menu_items)) {

            throw new \Exception('هیچ آیتمی در این منو وجود ندارد', 404);

        }

        $formatted_menu = $this->format_menu_items($menu_items);

        return $formatted_menu;
    }

    public function format_menu_items($menu_items)
    {
        $formatted        = [  ];
        $menu_items_by_id = [  ];

        foreach ($menu_items as $item) {
            $menu_items_by_id[ $item->ID ] = $item;
        }

        foreach ($menu_items as $item) {
            $formatted_item = [
                'id'               => $item->ID,
                'title'            => $item->title,
                'url'              => $item->url,
                'children'         => [  ],
             ];

            if ($item->menu_item_parent > 0 && isset($menu_items_by_id[ $item->menu_item_parent ])) {
                continue;
            }

            $formatted[  ] = $formatted_item;
        }

        foreach ($formatted as &$parent_item) {
            $parent_item[ 'children' ] = $this->get_menu_children($menu_items, $parent_item[ 'id' ]);
        }

        return $formatted;
    }

    public function get_menu_children($menu_items, $parent_id)
    {
        $children = [  ];

        foreach ($menu_items as $item) {
            if ($item->menu_item_parent == $parent_id) {
                $child_item = [
                    'id'               => $item->ID,
                    'title'            => $item->title,
                    'url'              => $item->url,
                    'children'         => $this->get_menu_children($menu_items, $item->ID),
                 ];

                $children[  ] = $child_item;
            }
        }

        return $children;
    }

}
