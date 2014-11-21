<?php

namespace jvwp;

abstract class PostType
{

    const SUPPORTS_TITLE = "title";
    const SUPPORTS_EDITOR = "editor";
    const SUPPORTS_AUTHOR = "author";
    const SUPPORTS_THUMBNAIL = "thumbnail";
    const SUPPORTS_EXCERPT = "excerpt";
    const SUPPORTS_TRACKBACKS = "trackbacks";
    const SUPPORTS_CUSTOM_FIELDS = "custom-fields";
    const SUPPORTS_COMMENTS = "comments";
    const SUPPORTS_REVISIONS = "revisions";
    const SUPPORTS_PAGE_ATTRIBUTES = "page-attributes";
    const SUPPORTS_POST_FORMATS = "post-formats";

    private $identifier;
    private $options;

    /**
     * @param string $identifier
     * @param string $singularName
     * @param string $pluralName
     * @param bool $public
     * @param array $supports
     * @param array $options
     * @param bool $register
     */
    function __construct($identifier, $singularName, $pluralName, $public = false, array $supports = [
            self::SUPPORTS_TITLE,
            self::SUPPORTS_EDITOR
        ], array $options = [], $register = true)
    {
        $this->identifier = $identifier;
        $this->options = array_merge([
            'public' => $public,
            'inherit_type' => 'page',
            'supports' => $supports,
            'capability_type' => 'page',
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'labels' => [
                'name' => $singularName,
                'menu_name' => $pluralName
            ]
        ], $options);
        if ($register) {
            add_action('init', [$this, 'register']);
        }
    }

    function register()
    {
        register_post_type($this->identifier, $this->options);
    }

} 