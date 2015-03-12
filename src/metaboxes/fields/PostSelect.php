<?php

namespace jvwp\metaboxes\fields;

use jvwp\common\Utils;

class PostSelect extends Select
{
    private $post_type;
    private $extra_args;

    public function __construct ($identifier, $label, $post_type = 'any', $multiple = false, array $extra_args = array(), $default = "")
    {
        parent::__construct($identifier, $label, array(), $multiple, $default);
        $this->post_type  = $post_type;
        $this->extra_args = $extra_args;
    }

    /**
     * @param $currentValue
     *
     * @return array
     */
    protected function getOptions ($currentValue)
    {
        $options = array();
        foreach (Utils::getPostsByType($this->post_type, $this->extra_args) as $post) {
            $options[] = array(
                'selected' => self::isSelected($post->ID, $currentValue),
                'value'    => $post->ID,
                'label'    => $post->post_title
            );
        }
        return $options;
    }

    private static function isSelected ($option, $currentValue)
    {
        if ($currentValue === "" || $currentValue === null || $currentValue === array())
            return false;
        if (!is_array($currentValue))
            $currentValue = array($currentValue);
        foreach ($currentValue as $v) {
            if ($v === "")
                continue;
            if (intval($v) === $option)
                return true;
        }
        return false;
    }

}