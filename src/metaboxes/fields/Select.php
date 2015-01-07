<?php

namespace jvwp\metaboxes\fields;

class Select extends Field
{

    private $multiple, $options;

    /**
     * Select box field for displaying posts of a certain post type
     *
     * @param string $identifier
     * @param string $label
     * @param array  $options  Array of associative arrays containing selected, value and label
     * @param bool   $multiple Multiple selected posts allowed?
     * @param string $default
     */
    public function __construct ($identifier, $label, array $options = array(), $multiple = false, $default = "")
    {
        parent::__construct($identifier, $label, $default);
        $this->multiple = $multiple;
        $this->options  = $options;
    }

    /**
     * Gets the HTML markup for a single <option> tag
     *
     * @param array $option Associative array containing selected, value and label
     *
     * @return string
     */
    protected function getOptionTag ($option)
    {
        return '<option ' . ($option['selected'] ? "selected" : "") . ' value=' . $option['value'] . '>' .
        $option['label'] .
        '</option>';
    }


    /**
     * Displays the field control with given value
     *
     * @param string $value
     */
    protected function output ($value)
    {
        $fieldName = $this->getFieldName();
        echo $this->getOpeningTag($fieldName);
        echo $this->getEmptyOptionTag();
        foreach ($this->getOptions($value) as $option)
            echo $this->getOptionTag($option);
        echo '</select>';
    }

    /**
     * @return string
     */
    protected function getEmptyLabel ()
    {
        return '---';
    }


    /**
     * Gets the HTML markup for the first, "empty" <option> tag
     * @return string
     */
    protected function getEmptyOptionTag ()
    {
        return '<option value="">' . $this->getEmptyLabel() . '</option>';
    }

    /**
     * @param $fieldName
     *
     * @return string
     */
    protected function getOpeningTag ($fieldName)
    {
        return '<select ' . ($this->multiple ? 'multiple ' : '') . 'style="width: 100%" id="' . $fieldName . '" name="' . $fieldName . ($this->multiple ? '[]' : '') . '">';
    }

    /**
     * Gets the available options in the form of an array of associative arrays containing selected, value and label
     *
     * @param mixed $currentValue currently selected value
     *
     * @return array
     */
    protected function getOptions ($currentValue)
    {
        return $this->options;
    }

}