<?php

namespace jvwp\rwmb;

class PostField extends Field {

    const TYPE = 'post';

    function __construct($name, $id, $field_type, $post_type, $desc = '', $std = '', $class = '', $clone = false, $options = array())
    {
        parent::__construct($name, $id, self::TYPE, $desc, $std, $class, $clone, array(
            'field_type' => $field_type,
            'post_type' => $post_type
        ));
    }

} 