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
     * @action
     */
    const WP_INSERT_POST = 'wp_insert_post';

    /**
     * This action is used to add extra submenus and menu options to the admin panel's menu structure. It runs after
     * the basic admin panel menu structure is in place.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
     * @action
     */
    const ADMIN_MENU = 'admin_menu';

    /**
     * The <pre>admin_init</pre> hook is triggered before any other hook when a user accesses the admin area. This hook
     * doesn't provide any parameters, so it can only be used to callback a specified function.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
     * @action
     */
    const ADMIN_INIT = 'admin_init';

    /**
     * The <pre>wp_enqueue_scripts</pre> hook is the proper hook to use when enqueuing items that are meant to appear
     * on the front end. Despite the name, it is used for enqueuing both scripts and styles.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
     * @action
     */
    const WP_ENQUEUE_SCRIPTS = 'wp_enqueue_scripts';

    /**
     * The <pre>admin_enqueue_scripts</pre> hook is the first action hooked into the admin scripts actions. It provides
     * a single parameter, the <pre>$hook_suffix</pre> for the current admin page.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
     * @action
     */
    const ADMIN_ENQUEUE_SCRIPTS = 'admin_enqueue_scripts';

    /**
     * Runs after WordPress has finished loading but before any headers are sent. Useful for intercepting
     * <pre>$_GET</pre> or <pre>$_POST</pre> triggers.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     * @action
     */
    const INIT = 'init';

    /**
     * This action hook is executed at the end of WordPress's built-in request parsing method in the main WP() class.
     * Attention! Parse Request affects only the main query not queries made with wp_query, for example.
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference/parse_request
     * @action
     */
    const PARSE_REQUEST = 'parse_request';

    /**
     * This action hook executes just before WordPress determines which template page to load. It is a good hook to use
     * if you need to do a redirect with full knowledge of the content that has been queried.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect
     * @action
     */
    const TEMPLATE_REDIRECT = 'template_redirect';

    /**
     * The "body_class" filter is used to filter the classes that are assigned to the body HTML element on the current
     * page.
     * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
     * @filter
     */
    const BODY_CLASS = 'body_class';

    /**
     * the_title is a filter applied to the post title retrieved from the database, prior to printing on the screen. In
     * some cases (such as when the_title is used), the title can be suppressed by returning a false value (e.g. NULL,
     * FALSE or the empty string) from the filter function.
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/the_title
     * @filter
     */
    const THE_TITLE = 'the_title';

    /**
     * The "the_content" filter is used to filter the content of the post after it is retrieved from the database and
     * before it is printed to the screen.
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content
     * @filter
     */
    const THE_CONTENT = 'the_content';

    /**
     * This filter can be used to alter the list of acceptable file extensions WordPress checks during media uploads.
     * Altering this list through the use of this filter can help you when you are presented with the
     * "File type does not meet security guidelines. Try another." error message.
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
     * @filter
     */
    const UPLOAD_MIMES = 'upload_mimes';

    /**
     * Filter used by the "subheading" plugin to filter the subtitle of a post.
     * @filter
     */
    const SUBHEADING = 'subheading';
}