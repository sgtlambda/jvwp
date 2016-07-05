<?php

namespace jvwp\rwmb;

class PostField extends Field
{

    const FIELD_TYPE_SELECT = 'select';
    const FIELD_TYPE_SELECT_ADVANCED = 'select_advanced';

    const TYPE = 'post';

    function __construct(
        $name, $id, $post_type, $field_type = self::FIELD_TYPE_SELECT, $desc = '', $std = '', $class = '',
        $clone = false, $options = array()
    ) {
        parent::__construct($name, $id, self::TYPE, $desc, $std, $class, $clone, array(
            'field_type' => $field_type,
            'post_type'  => $post_type
        ));
    }

} 