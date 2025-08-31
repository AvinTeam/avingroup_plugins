<?php
namespace AvinGroup\App\Modules\Menus;

use AvinGroup\App\Core\Menu;
use AvinGroup\App\Core\Option;

(defined('ABSPATH')) || exit;

class SettingMenu extends Menu
{
    public function __construct()
    {
        add_action('admin_menu', [ $this, 'admin_menu' ]);
    }

    public function admin_menu(string $context): void
    {

        $suffix = add_menu_page(
            'تنظیمات',
            'تنظیمات',
            'manage_options',
            'setting-menu',
            [ $this, 'view' ],
            'dashicons-admin-tools',
            1
        );

        add_action('load-' . $suffix, [ $this, 'processing' ]);

    }

    public function view()
    {

        view('menus/setting', [ 'setting' => Option::getSetting() ]);

    }

    public function processing()
    {
        if (isset($_POST[ 'act' ]) && $_POST[ 'act' ] == "settingSubmit" && wp_verify_nonce($_POST[ '_wpnonce' ], config('app.key') . '_setting_' . get_current_user_id())) {


            Option::setSetting($_POST["setting"]);


            $this->success('تغییر با موفقیت انجام شد');

        }
    }

}
