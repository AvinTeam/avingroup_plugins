<?php
namespace AvinGroup\App\Core;

(defined('ABSPATH')) || exit;

class Option
{

    public static function getSetting()
    {
        $defaultSetting = [
            'footerText' => '',
            'address'    => '',
            'email'      => '',
            'phone'      => '',
            'social'     => [  ],
         ];

        $setting = get_option('agSetting', [  ]);

        return array_merge($defaultSetting, $setting);
    }

    public static function setSetting(array $input)
    {
        $defaultSetting = [
            'footerText' => '',
            'address'    => '',
            'email'      => '',
            'phone'      => '',
            'social'     => [  ],
         ];

        $setting = get_option('agSetting', [  ]);

        $setting = array_merge($defaultSetting, $setting);

        $setting = array_merge($setting, $input);

        update_option('agSetting', $setting);

        return $setting;
    }
}