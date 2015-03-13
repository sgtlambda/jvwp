<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */

namespace jvwp\metaboxes;

use jvwp\metaboxes\fields\Checkbox;

class FlagsMetaBox extends MetaBox
{

    private $checks;

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
        foreach ($flags as $key => $label) {
            $check          = new Checkbox($key, $label, false);
            $this->checks[] = $check;
        }
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


}