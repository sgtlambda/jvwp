<?php

namespace jvwp\admin\metaboxes\fields;

class Checkbox extends Field
{

    const ON = 'on';

    public function __construct ($identifier, $label, $checked = false)
    {
        parent::__construct($identifier, $label, $checked ? self::ON : '');
    }

    protected function getVerifyFieldName ()
    {
        return $this->getFieldName() . '-verify';
    }

    protected function getVerifyFieldValue ()
    {
        return 'true';
    }

    protected function wasVerified ()
    {
        if (!array_key_exists($this->getVerifyFieldName(), $_POST))
            return false;
        return $_POST[$this->getVerifyFieldName()] === $this->getVerifyFieldValue();
    }

    protected static function isChecked ($value)
    {
        return $value === self::ON;
    }

    public function getType ()
    {
        return 'checkbox';
    }

    /**
     * Displays the field control with given value
     *
     * @param string $value
     */
    protected function output ($value)
    {
        $checked = self::isChecked($value) ? 'checked' : '';
        $on      = self::ON;
        echo "<input type=\"hidden\" name=\"{$this->getVerifyFieldName()}\" value=\"{$this->getVerifyFieldValue()}\" />";
        echo "<input type=\"checkbox\" name=\"{$this->getFieldName()}\" id=\"{$this->getFieldName()}\" value=\"{$on}\" " . $checked . "/>";
    }

    protected function doSave ()
    {
        return $this->wasVerified();
    }

    protected function getPostValue ()
    {
        if (!array_key_exists($this->getFieldName(), $_POST))
            return '';
        return parent::getPostValue();
    }
}