<?php

namespace jvwp\constants;
/**
 * This class should eventually include constants and documentation for every hook
 */
class Hooks
{

    /**
     * The wp_insert_post action fires once a post has been saved. You have the ability to set it to only fire on new
     * posts or on all save actions using the parameters. Please see
     * <a href="http://codex.wordpress.org/Plugin_API/Action_Reference/save_post">Plugin_API/Action_Reference/save_post
     * </a> for more information. Keep in mind that this action is called both for actions in the admin as well as
     * anytime the wp_insert_post() function is invoked.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/wp_insert_post
     */
    const WP_INSERT_POST = 'wp_insert_post';

    /**
     * This action is used to add extra submenus and menu options to the admin panel's menu structure. It runs after
     * the basic admin panel menu structure is in place.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
     */
    const ADMIN_MENU = 'admin_menu';
    const ADMIN_INIT = 'admin_init';
}