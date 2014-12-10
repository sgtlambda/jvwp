<?php

namespace jvwp\rwmb;

class Field
{

    const TYPE_BUTTON     = 'button';
    const TYPE_CHECKBOX   = 'checkbox';
    const TYPE_COLOR      = 'color';
    const TYPE_DIVIDER    = 'divider';
    const TYPE_FILE_INPUT = 'file_input';
    const TYPE_HEADING    = 'heading';
    const TYPE_HIDDEN     = 'hidden';
    const TYPE_MAP        = 'map';
    const TYPE_NUMBER     = 'number';
    const TYPE_OEMBED     = 'oembed';
    const TYPE_PASSWORD   = 'password';
    const TYPE_RANGE      = 'range';
    const TYPE_SLIDER     = 'slider';
    const TYPE_URL        = 'url';
    const TYPE_USER       = 'user';

    private $name, $id, $type, $desc, $std, $class, $clone, $options;

    /**
     * @var RWMB
     */
    private $box;

    /**
     * @param string $name
     * @param string $id
     * @param string $type
     * @param string $desc
     * @param string $std
     * @param string $class
     * @param bool   $clone
     */
    function __construct($name, $id, $type, $desc = '', $std = '', $class = '', $clone = false, $options = array())
    {
        $this->name  = $name;
        $this->id    = $id;
        $this->type  = $type;
        $this->desc  = $desc;
        $this->std   = $std;
        $this->class = $class;
        $this->clone = $clone;
    }

    /**
     * @param RWMB $box
     */
    public function setBox(RWMB $box)
    {
        $this->box = $box;
    }

    /**
     * @return array
     */
    public function describe()
    {
        return array_merge(array(
            'id'   => $this->getFormId(),
            'name' => $this->name,
            'type' => $this->type
        ), $this->options);
    }

    public function getFormId()
    {
        return $this->box->getId() . '-' . $this->id;
    }

} 