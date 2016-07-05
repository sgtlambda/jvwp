<?php

namespace jvwp\admin\metaboxes\fields;

class TextField extends Field
{

    const TYPE_TEXT     = 'text';
    const TYPE_PASSWORD = 'password';

    private $type;

    public function __construct ($identifier, $label, $type = self::TYPE_TEXT, $default = "")
    {
        parent::__construct($identifier, $label, $default);
        $this->type = $type;
    }

    /**
     * Displays the field control with given value
     *
     * @param string $value
     */
    protected function output ($value)
    {
        $fieldName = $this->getFieldName();
        echo "<input type=\"{$this->type}\" name=\"{$fieldName}\" value=\"{$value}\">";
    }

}