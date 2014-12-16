<?php

namespace jvwp\metaboxes\fields;

abstract class Field
{

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
     * @param int $post_ID
     *
     * @return string
     */
    public function getValue ($post_ID)
    {
        $value = get_post_meta($post_ID, $this->identifier, true);
        if ($value === '')
            return $this->default;
        else
            return $value;
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
        $this->output($this->getValue($post->ID));
    }

    /**
     * Saves the updated meta value to the database
     *
     * @param int $post_ID
     */
    public function save ($post_ID)
    {
        $fieldName = $this->getFieldName();
        if (isset($_POST[$fieldName]))
            update_post_meta($post_ID, $this->identifier, $_POST[$fieldName]);
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

}