<?php

namespace jvwp\common;

class Ajax
{

    const REGISTER_BOTH = 'both';

    /**
     * The hook prefix
     */
    const WP_AJAX_HOOK_PREFIX = 'wp_ajax_';

    /**
     * The nopriv (not logged in) prefix
     */
    const WP_AJAX_NOPRIV_HOOK_PREFIX = 'wp_ajax_nopriv_';

    /**
     * Gets the action hook string to use, based on the action name that was provided
     *
     * @param string $action
     * @param bool   $noPriv
     *
     * @return string
     */
    public static function getHook ($action, $noPriv = false)
    {
        return ($noPriv ? self::WP_AJAX_NOPRIV_HOOK_PREFIX : self::WP_AJAX_HOOK_PREFIX) . $action;
    }

    /**
     * Binds the callable to the given hook
     *
     * @param string      $action   The name of the ajax action
     * @param callable    $callable The function to bind
     * @param bool|string $noPriv   Whether to enable nopriv in the hook
     */
    public static function register ($action, $callable, $noPriv = false)
    {
        if (!$noPriv || $noPriv === self::REGISTER_BOTH)
            add_action(self::getHook($action), $callable);
        if ($noPriv || $noPriv === self::REGISTER_BOTH)
            add_action(self::getHook($action, true), $callable);
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