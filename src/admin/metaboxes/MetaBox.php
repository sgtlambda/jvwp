<?php

namespace jvwp\admin\metaboxes;

use jvwp\constants\Hooks;
use WP_Post;

abstract class MetaBox
{

    const CONTEXT_NORMAL   = 'normal';
    const CONTEXT_ADVANCED = 'advanced';
    const CONTEXT_SIDE     = 'side';

    const PRIORITY_LOW     = 'low';
    const PRIORITY_DEFAULT = 'default';
    const PRIORITY_CORE    = 'core';
    const PRIORITY_HIGH    = 'high';

    protected $id, $title, $screens, $context, $priority;

    /**
     * WP Meta Box abstraction class. The class should be instantiated on the <code>admin_menu</code> hook.
     *
     * @param string  $id       HTML 'id' attribute of the edit screen section
     * @param string  $title    Title of the edit screen section, visible to user
     * @param array   $screens  An array of post types on which to show the meta box in the edit screen
     * @param string  $context  The part of the page where the edit screen section should be shown
     * @param string  $priority The priority within the context where the boxes should show
     * @param boolean $register Whether to register the meta box on instantiation
     */
    function __construct (
        $id, $title, array $screens = array(), $context = self::CONTEXT_ADVANCED, $priority = self::PRIORITY_DEFAULT,
        $register = true
    )
    {
        $this->id       = $id;
        $this->title    = $title;
        $this->screens  = $screens;
        $this->context  = $context;
        $this->priority = $priority;
        if ($register)
            $this->addActions();
    }

    /**
     * This method is used to output the contents of the meta box.
     *
     * @param WP_Post $post
     */
    public abstract function display ($post);

    /**
     * This method is ran every time a post is saved. Update your post meta here.
     *
     * @param $post_ID
     */
    public function save ($post_ID)
    {
        // TODO should probably automatically include nonce verification or sth
    }

    /**
     * Adds the meta box using the <code>add_meta_box()</code> function.
     * This should always be called on the <code>admin_menu</code> hook.
     */
    public function register ()
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

    private function getPropertyForScreen ($screen, $property, $default = null)
    {
        if (!is_array($property))
            return $property;
        else if (array_key_exists($screen, $property))
            return $property[$screen];
        else return $default;
    }

    protected function addActions ()
    {
        add_action('admin_menu', array($this, 'register'));
        add_action(Hooks::WP_INSERT_POST, array($this, 'save'));
    }

    /**
     * @return string
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * If the metabox is not registered as a native meta box, use this function to display it using WP markup
     *
     * @param WP_Post|string $post
     */
    public function shim ($post)
    {
        ?>
        <div class="postbox ">
            <h3 class=""><span><?php echo $this->title; ?></span></h3>

            <div class="inside">
                <?php $this->display($post); ?>
            </div>
        </div>
    <?php
    }
} 