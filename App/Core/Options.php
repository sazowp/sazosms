<?php
namespace SazoWP\App\Core;

(defined('ABSPATH')) || exit;

class Options
{
    private static string $optionKey = '';

    protected static function setKey()
    {
        self::$optionKey = config('app.key') . 'general_setting';
    }

    protected static function getter()
    {
        self::setKey();
        return get_option(self::$optionKey, [  ]);

    }

    protected static function setter(array $input)
    {
        self::setKey();

        $setting = get_option(self::$optionKey);

        if (empty($setting)) {$setting = [  ];}
        $setting = array_merge($setting, $input);

        return update_option(self::$optionKey, $setting);
    }
}
