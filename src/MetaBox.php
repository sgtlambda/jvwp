<?php

namespace jvwp;

abstract class MetaBox
{

    const SCREEN_POST       = 'post';
    const SCREEN_PAGE       = 'page';
    const SCREEN_DASHBOARD  = 'dashboard';
    const SCREEN_LINK       = 'link';
    const SCREEN_ATTACHMENT = 'attachment';

    const CONTEXT_NORMAL   = 'normal';
    const CONTEXT_ADVANCED = 'advanced';
    const CONTEXT_SIDE     = 'side';

    const PRIORITY_LOW     = 'low';
    const PRIORITY_DEFAULT = 'default';
    const PRIORITY_CORE    = 'core';
    const PRIORITY_HIGH    = 'high';

    private $id, $title, $screens, $context, $priority;

    /**
     * WP Meta Box abstraction class. The class should be instantiated on the <code>admin_menu</code> hook.
     *
     * @param string  $id       HTML 'id' attribute of the edit screen section
     * @param string  $title    Title of the edit screen section, visible to user
     * @param array   $screens  An array of Write screens on which to show the edit screen section
     * @param string  $context  The part of the page where the edit screen section should be shown
     * @param string  $priority The priority within the context where the boxes should show
     * @param boolean $register Whether to register the meta box on instantiation
     */
    function __construct(
        $id, $title, array $screens = array(), $context = self::CONTEXT_ADVANCED, $priority = self::PRIORITY_DEFAULT,
        $register = true
    ) {
        $this->id       = $id;
        $this->title    = $title;
        $this->screens  = $screens;
        $this->context  = $context;
        $this->priority = $priority;
        if ($register) {
            add_action('admin_menu', array($this, 'register'));
            add_action('wp_insert_post', array($this, 'save'));
        }
    }

    /**
     * This method is used to output the contents of the meta box.
     *
     * @param $post
     */
    public abstract function display($post);

    /**
     * This method is ran every time a post is saved. Update your post meta here.
     *
     * @param $post_ID
     */
    public function save($post_ID)
    {

    }

    /**
     * Adds the meta box using the <code>add_meta_box()</code> function.
     * This should always be called on the <code>admin_menu</code> hook.
     */
    public final function register()
    {
        $callback = array($this, 'display');
        foreach ($this->screens as $screen) {
            $id       = $this->getPropertyForScreen($screen, $this->id);
            $title    = $this->getPropertyForScreen($screen, $this->title);
            $context  = $this->getPropertyForScreen($screen, $this->context);
            $priority = $this->getPropertyForScreen($screen, $this->priority);
            add_meta_box($id, $title, $callback, $screen, $context, $priority);
        }
    }

    private function getPropertyForScreen($screen, $property, $default = null)
    {
        if (!is_array($property))
            return $property;
        else if (array_key_exists($screen, $property))
            return $property[$screen];
        else return $default;
    }
} 