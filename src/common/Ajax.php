<?php

namespace jvwp\common;

class Ajax
{

    /**
     * The hook prefix
     */
    const WP_AJAX_HOOK_PREFIX = 'wp_ajax_';

    /**
     * Gets the action hook string to use, based on the action name that was provided
     *
     * @param string $action
     *
     * @return string
     */
    public static function getHook ($action)
    {
        return self::WP_AJAX_HOOK_PREFIX . $action;
    }

    /**
     * Binds the callable to the given hook
     *
     * @param string   $action   The name of the ajax action
     * @param callable $callable The function to bind
     */
    public static function register ($action, $callable)
    {
        add_action(self::getHook($action), $callable);
    }

    /**
     * Normalizes the string to use in an action name, making the string lowercase and replacing every instance of a
     * non-word and non-digit character with an underscore
     *
     * @param $actionName
     *
     * @return string
     */
    public static function normalizeActionName ($actionName)
    {
        return preg_replace('/[^\w\d]+/', '_', strtolower($actionName));
    }
}