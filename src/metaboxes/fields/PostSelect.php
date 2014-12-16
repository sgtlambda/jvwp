<?php

namespace jvwp\metaboxes\fields;

use jvwp\Utils;

class PostSelect extends Field
{

    private $post_type, $extra_args;

    public function __construct ($identifier, $label, $post_type = "post", array $extra_args = array(), $default = "")
    {
        parent::__construct($identifier, $label, $default);
        $this->post_type  = $post_type;
        $this->extra_args = $extra_args;
    }


    /**
     * Displays the field control with given value
     *
     * @param string $value
     */
    protected function output ($value)
    {
        $posts     = Utils::getPostsByType($this->post_type, $this->extra_args);
        $fieldName = $this->getFieldName();
        echo '<select style="width: 100%" id="' . $fieldName . '" name="' . $fieldName . '">';
        echo '<option value="">---</option>';
        foreach ($posts as $post) {
            $postID   = $post->ID;
            $selected = ($value !== "" && $postID === intval($value)) ? "selected" : "";
            echo '<option ' . $selected . ' value=' . $postID . '>' . $post->post_title . '</option>';
        }
        echo '</select>';
    }


}