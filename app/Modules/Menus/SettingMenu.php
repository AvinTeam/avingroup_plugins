<?php
namespace AvinGroup\App\Modules\Menus;

use AvinGroup\App\Core\Menu;
use AvinGroup\App\Options\Settings;

(defined('ABSPATH')) || exit;

class SettingMenu extends Menu
{
    public function __construct()
    {
        add_action('admin_menu', [ $this, 'admin_menu' ]);
    }

    public function admin_menu(string $context): void
    {

        $suffix = add_submenu_page(
            'options-general.php',
            'تنظیمات آوین گروپ',
            'تنظیمات آوین گروپ',
            'manage_options',
            'avingroup-setting',
            [ $this, 'view' ],
        );

        add_action('load-' . $suffix, [ $this, 'processing' ]);

    }

    public function view()
    {

        $setting = Settings::get();

        $setting[ "logoImage" ] = (! empty($setting[ "logo" ])) ? wp_get_attachment_url($setting[ "logo" ]) : '';

        view('menus/setting', $setting);

    }

    public function processing()
    {
        if (isset($_POST[ 'act' ]) && $_POST[ 'act' ] == "settingSubmit" && wp_verify_nonce($_POST[ '_wpnonce' ], config('app.key') . '_setting_' . get_current_user_id())) {

            Settings::set($_POST[ "setting" ]);

            $this->success('تغییر با موفقیت انجام شد');

        }
    }

}
