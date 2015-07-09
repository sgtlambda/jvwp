<?php

namespace jvwp\common;

use jvwp\constants\Hooks;

class WpAdmin
{

    const MENU_THEMES = 'themes.php';

    const ADMIN_MENU_PAGE_PLUGINS  = 'plugins.php';
    const ADMIN_MENU_PAGE_COMMENTS = 'edit-comments.php';

    /**
     * Sets the theme to the provided theme name and removes the theme selection screen
     *
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

    /**
     * Removes the "plugins" navigation link from the administration interface
     */
    public static function hidePluginsMenu ()
    {
        add_action(Hooks::ADMIN_MENU, function () {
            remove_menu_page(self::ADMIN_MENU_PAGE_PLUGINS);
        });
    }

    /**
     * Removes the "comments" navigation link from the administration interface
     */
    public static function hideCommentsMenu ()
    {
        add_action(Hooks::ADMIN_MENU, function () {
            remove_menu_page(self::ADMIN_MENU_PAGE_COMMENTS);
        });
    }
}