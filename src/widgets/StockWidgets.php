<?php

namespace jvwp\widgets;

/**
 * Utility class for dealing with WordPress' built-in widgets
 * @package jvwp\widgets
 */
class StockWidgets
{

    const STOCK_WP_WIDGET_PAGES           = 'WP_Widget_Pages';
    const STOCK_WP_WIDGET_CALENDAR        = 'WP_Widget_Calendar';
    const STOCK_WP_WIDGET_ARCHIVES        = 'WP_Widget_Archives';
    const STOCK_WP_WIDGET_LINKS           = 'WP_Widget_Links';
    const STOCK_WP_WIDGET_META            = 'WP_Widget_Meta';
    const STOCK_WP_WIDGET_SEARCH          = 'WP_Widget_Search';
    const STOCK_WP_WIDGET_TEXT            = 'WP_Widget_Text';
    const STOCK_WP_WIDGET_CATEGORIES      = 'WP_Widget_Categories';
    const STOCK_WP_WIDGET_RECENT_POSTS    = 'WP_Widget_Recent_Posts';
    const STOCK_WP_WIDGET_RECENT_COMMENTS = 'WP_Widget_Recent_Comments';
    const STOCK_WP_WIDGET_RSS             = 'WP_Widget_RSS';
    const STOCK_WP_WIDGET_TAG_CLOUD       = 'WP_Widget_Tag_Cloud';
    const STOCK_WP_NAV_MENU_WIDGET        = 'WP_Nav_Menu_Widget';

    /**
     * By means of class reflection, gets a list of all the classnames of the stock widgets
     * @return string[]
     */
    private static function getStockWidgets ()
    {
        $reflectionClass = new \ReflectionClass(get_class());
        $classNames      = array();
        foreach ($reflectionClass->getConstants() as $name => $value)
            if (preg_match('/^STOCK_WP/', $name))
                $classNames[] = $value;
        return $classNames;
    }

    /**
     * Enqueues the unregistration of the provided widgets on the widgets_init action hook
     *
     * @param string[] $widgets
     */
    public static function unregister ($widgets)
    {
        add_action('widgets_init', function () use ($widgets) {
            foreach ($widgets as $stockWidget)
                unregister_widget($stockWidget);
        });
    }

    /**
     * Opinionated method that returns the classnames of the useful widgets amongst the stock WP widgets
     * @return array
     */
    private static function getUsefulWidgets ()
    {
        return array(
            self::STOCK_WP_NAV_MENU_WIDGET,
            self::STOCK_WP_WIDGET_TEXT
        );
    }

    /**
     * Unregisters all WordPress built-in widgets
     */
    public static function unregisterAll ()
    {
        self::unregister(self::getStockWidgets());
    }

    /**
     * Unregisters all WordPress built-in widgets that are not commonly used
     */
    public static function unregisterUseless ()
    {
        self::unregister(array_diff(self::getStockWidgets(), self::getUsefulWidgets()));
    }
}