<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */

namespace jvwp\admin\metaboxes;

use jvwp\admin\metaboxes\fields\Checkbox;
use jvwp\common\Post;
use jvwp\constants\PostTypes;

class FlagsMetaBox extends MetaBox
{

    private $checks;
    private $flags;

    /**
     * @param string      $id
     * @param string      $title
     * @param array       $flags An associative array of key => label bindings
     * @param array       $screens
     * @param string      $context
     * @param bool|string $priority
     * @param bool        $register
     */
    function __construct (
        $id, $title, array $flags, array $screens = array(), $context = self::CONTEXT_ADVANCED, $priority = self::PRIORITY_DEFAULT,
        $register = true
    )
    {
        parent::__construct($id, $title, $screens, $context, $priority, $register);
        $this->checks = array();
        $this->flags  = $flags;
        foreach ($flags as $key => $label) {
            $check          = new Checkbox($key, $label, false);
            $this->checks[] = $check;
        }
    }

    /**
     * Finds one or more posts that have the given flag enabled
     *
     * @param string $flag
     * @param string $post_type
     *
     * @return \WP_Post[]
     */
    public static function findPostsByFlag ($flag, $post_type = PostTypes::ANY)
    {
        return Post::findByExactMeta($flag, Checkbox::ON, $post_type);
    }

    /**
     * This method is used to output the contents of the meta box.
     *
     * @param $post
     */
    public function display ($post)
    {
        foreach ($this->checks as $check)
            /* @var $check Checkbox */
            $check->display($post);
    }

    public function save ($post_ID)
    {
        parent::save($post_ID);
        foreach ($this->checks as $check)
            /* @var $check Checkbox */
            $check->save($post_ID);
    }

    /**
     * Gets an array of the identifiers for the flags that are enabled on the current (or provided) post
     *
     * @param int|\WP_Post $post
     *
     * @return string[]
     */
    public function getPostFlags ($post = 0)
    {
        $post = get_post($post);
        if ($post === null)
            return [];
        $flags = [];
        foreach ($this->flags as $key => $label)
            if (get_post_meta($post->ID, $key, true) === Checkbox::ON)
                $flags[] = $key;
        return $flags;
    }
}