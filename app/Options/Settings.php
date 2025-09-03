<?php
namespace AvinGroup\App\Options;

(defined('ABSPATH')) || exit;

class Settings
{
    private static string $optionKey = 'agSetting';

    private static array $defaultSetting = [
        'logo'       => '',
        'footerText' => '',
        'address'    => '',
        'email'      => '',
        'phone'      => '',
        'social'     => [  ],
     ];

    public static function get()
    {

        $setting = get_option(self::$optionKey, [  ]);

        return array_merge(self::$defaultSetting, $setting);
    }

    public static function set(array $input)
    {

        $setting = get_option(self::$optionKey, [  ]);

        $setting = array_merge(self::$defaultSetting, $setting);

        $setting = array_merge($setting, $input);

        update_option(self::$optionKey, $setting);

        return $setting;
    }
}
