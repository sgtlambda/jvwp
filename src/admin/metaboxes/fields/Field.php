<?php

namespace jvwp\admin\metaboxes\fields;

use WP_Post;

abstract class Field
{

    /**
     * Pass this as the Post object in order to assign the meta field to a side-wide setting
     */
    const SITE = '_global';

    private $identifier, $label, $default;

    /**
     * Utility class for displaying and saving meta box fields.
     *
     * @param string $identifier
     * @param string $label   Label to display
     * @param string $default Default value
     */
    public function __construct ($identifier, $label, $default = "")
    {
        $this->identifier = $identifier;
        $this->label      = $label;
        $this->default    = $default;
    }

    /**
     * Gets the value of this field for a given post
     *
     * @param int|string $post_ID The post ID or <pre>Field::SITE</pre> if it is a global option
     *
     * @return string
     */
    public function getValue ($post_ID)
    {
        if ($post_ID === self::SITE)
            return get_option($this->identifier, $this->default);
        else {
            $value = get_post_meta($post_ID, $this->identifier, true);
            return $value === '' ? $this->default : $value;
        }
    }

    /**
     * Displays the field control with given value
     *
     * @param string $value
     */
    abstract protected function output ($value);

    /**
     * Displays the field control for a given post
     *
     * @param WP_Post $post
     */
    public function display ($post)
    {
        $this->outputLabel();
        $identifier = $post instanceof WP_Post ? $post->ID : $post;
        $this->output($this->getValue($identifier));
    }

    /**
     * Saves the updated meta value to the database
     *
     * @param int|string $post_ID The post ID or <pre>Field::SITE</pre> if it is a global option
     */
    public function save ($post_ID)
    {
        if (!$this->doSave())
            return;
        if ($post_ID === self::SITE)
            update_option($this->identifier, $this->getPostValue());
        else
            update_post_meta($post_ID, $this->identifier, $this->getPostValue());
    }

    /**
     * @return string
     */
    protected function getFieldName ()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    protected function outputLabel ()
    {
        echo '<label for="' . $this->getFieldName() . '">' . $this->getLabel() . '</label>';
    }

    /**
     * @return bool
     */
    protected function doSave ()
    {
        return isset($_POST[$this->getFieldName()]);
    }

    /**
     * @return mixed
     */
    protected function getPostValue ()
    {
        return $_POST[$this->getFieldName()];
    }
}