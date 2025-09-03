<?php
namespace AvinGroup\App\Services\Options;

use AvinGroup\App\Options\Settings;
use AvinGroup\App\Services\Service;

(defined('ABSPATH')) || exit;

class OptionsService extends Service
{

    public function index()
    {
        $setting = Settings::get();
        $setting[ "logo" ] = (! empty($setting[ "logo" ])) ? wp_get_attachment_url($setting[ "logo" ]) : '';
        $setting[ 'header-menu' ] = $this->get_menu_by_location('main-menu');
        $setting[ 'footer-menu' ] = $this->get_menu_by_location('footer-menu');

        return $setting;
    }

    public function get_menu_by_location($location)
    {

        $menu_locations = get_nav_menu_locations();

        if (! isset($menu_locations[ $location ])) {

            return [  ];
        }

        $menu_items = wp_get_nav_menu_items($menu_locations[ $location ]);

        if (empty($menu_items)) {

            return [  ];

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
                'id'       => $item->ID,
                'title'    => $item->title,
                'url'      => ($item->object == "custom") ? $item->url : basename(rtrim($item->url, '/')),
                'type'     => $item->object,
                'children' => [  ],
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
                    'id'       => $item->ID,
                    'title'    => $item->title,
                    'url'      => ($item->object == "custom") ? $item->url : basename(rtrim($item->url, '/')),
                    'type'     => $item->object,
                    'children' => $this->get_menu_children($menu_items, $item->ID),
                 ];

                $children[  ] = $child_item;
            }
        }

        return $children;
    }

}