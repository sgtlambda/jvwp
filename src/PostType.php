<?php

namespace jvwp;

abstract class PostType
{

    const SUPPORTS_TITLE           = "title";
    const SUPPORTS_EDITOR          = "editor";
    const SUPPORTS_AUTHOR          = "author";
    const SUPPORTS_THUMBNAIL       = "thumbnail";
    const SUPPORTS_EXCERPT         = "excerpt";
    const SUPPORTS_TRACKBACKS      = "trackbacks";
    const SUPPORTS_CUSTOM_FIELDS   = "custom-fields";
    const SUPPORTS_COMMENTS        = "comments";
    const SUPPORTS_REVISIONS       = "revisions";
    const SUPPORTS_PAGE_ATTRIBUTES = "page-attributes";
    const SUPPORTS_POST_FORMATS    = "post-formats";

    private $identifier;
    private $options;
    private $taxonomies;

    /**
     * @param string $identifier
     * @param string $singularName
     * @param string $pluralName
     * @param bool   $public
     * @param array  $supports
     * @param array  $options
     * @param bool   $register
     * @param array  $taxonomies Taxonomies to add. Should be an array of associative arrays each containing a
     *                           'taxonomy' and an 'args' value
     */
    function __construct ($identifier, $singularName, $pluralName, $public = false, array $supports = array(
        self::SUPPORTS_TITLE,
        self::SUPPORTS_EDITOR
    ), array $options = array(), $register = true, array $taxonomies = array())
    {
        $this->identifier = $identifier;
        $this->options    = array_merge(array(
            'public'            => $public,
            'inherit_type'      => 'page',
            'supports'          => $supports,
            'capability_type'   => 'page',
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'labels'            => array(
                'name'          => $pluralName,
                'singular_name' => $singularName,
                'menu_name'     => $pluralName
            )
        ), $options);
        $this->taxonomies = $taxonomies;
        if ($register) {
            add_action('init', array($this, 'register'));
        }
    }

    /**
     * Adds a taxonomy to this post type.
     *
     * @param       $taxonomy
     * @param array $args
     */
    function addTaxonomy ($taxonomy, array $args = array())
    {
        $this->taxonomies[] = array(
            'taxonomy' => $taxonomy,
            'args'     => $args
        );
    }

    /**
     * Registers the post type globally with WordPress
     */
    function register ()
    {
        register_post_type($this->identifier, $this->options);
        $this->registerTaxonomies();
    }

    function registerTaxonomies ()
    {
        while (($tax = array_shift($this->taxonomies)) !== null) {
            register_taxonomy(
                $tax['taxonomy'],
                $this->identifier,
                isset($tax['args']) ? $tax['args'] : array()
            );
        }
    }

} 