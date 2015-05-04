<?php

namespace jvwp\common;


class WpAdmin
{

    const MENU_THEMES = 'themes.php';

    /**
     * Sets the theme to the provided theme name and removes the theme selection screen
     * @param string $theme_name
     */
    public static function lockTheme ($theme_name)
    {
        update_option('template', $theme_name);
        update_option('stylesheet', $theme_name);
        update_option('current_theme', $theme_name);
        add_action('admin_init', function () {
            global $submenu;
            unset($submenu[self::MENU_THEMES][5]);
            $submenu[self::MENU_THEMES][6][2] = "customize.php?return=" . urlencode(get_admin_url());
        });
    }

    public static function hidePluginsMenu ()
    {
        add_action('admin_menu', function () {
            remove_menu_page('plugins.php');
        });
    }
}