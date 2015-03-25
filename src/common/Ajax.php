<?php

namespace jvwp\common;

class Ajax
{

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