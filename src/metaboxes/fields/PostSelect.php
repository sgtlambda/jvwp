<?php

namespace jvwp\metaboxes\fields;

use jvwp\Utils;

class PostSelect extends Field
{

    private $post_type, $extra_args, $multiple;

    /**
     * Select box field for displaying posts of a certain post type
     *
     * @param string $identifier
     * @param string $label
     * @param string $post_type
     * @param bool   $multiple Multiple selected posts allowed?
     * @param array  $extra_args
     * @param string $default
     */
    public function __construct ($identifier, $label, $post_type = "post", $multiple = false, array $extra_args = array(), $default = "")
    {
        parent::__construct($identifier, $label, $default);
        $this->post_type  = $post_type;
        $this->extra_args = $extra_args;
        $this->multiple   = $multiple;
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
        if($this->multiple)
            echo '<select multiple style="width: 100%" id="' . $fieldName . '" name="' . $fieldName . '[]">';
        else
            echo '<select style="width: 100%" id="' . $fieldName . '" name="' . $fieldName . '">';
        echo '<option value="">---</option>';
        foreach ($posts as $post) {
            $postID   = $post->ID;
            $selected = (($value !== "" && !is_array($value) && $postID === intval($value)) || (is_array($value) && in_array($postID, $value))) ? "selected" : "";
            echo '<option ' . $selected . ' value=' . $postID . '>' . $post->post_title . '</option>';
        }
        echo '</select>';
    }


}