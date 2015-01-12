<?php

namespace jvwp\metaboxes\fields;

class TaxSelect extends Select
{

    private $tax, $extra_args;

    public function __construct ($identifier, $label, $tax = array('post_tag'), $multiple = true, array $extra_args = array(), $default = "")
    {
        parent::__construct($identifier, $label, array(), $multiple, $default);
        $this->tax        = $tax;
        $this->extra_args = $extra_args;
    }

    protected function getOptions ($currentValue)
    {
        $options = array();
        foreach (get_terms($this->tax, array_merge(array(
            'hide_empty' => false
        ), $this->extra_args)) as $term) {
            $value     = $term['slug'];
            $options[] = array(
                'label'    => $term['name'],
                'value'    => $value,
                'selected' => self::isSelected($term['slug'], $currentValue)
            );
        }
        return $options;
    }

    private static function isSelected ($option, $currentValue)
    {
        if (!is_array($currentValue))
            $currentValue = array($currentValue);
        foreach ($currentValue as $v)
            if ($option === $v)
                return true;
        return false;
    }

}