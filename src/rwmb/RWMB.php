<?php

namespace jvwp\rwmb;

use jvwp\MetaBox;

class RWMB extends MetaBox
{

    const HOOK_RWMB_META_BOXES = 'rwmb_meta_boxes';

    private $fields;

    /**
     * Adds the field to the MetaBox, if not present
     *
     * @param Field $field
     */
    public function addField(Field $field)
    {
        if (array_search($field, $this->fields) === false)
            $this->fields[] = $field;
    }

    /**
     * Removes the field from the MetaBox, if present
     *
     * @param Field $field
     */
    public function removeField(Field $field)
    {
        if (($index = array_search($field, $this->fields)) !== false)
            array_splice($this->fields, $index, 1);
    }

    protected function addActions()
    {
        parent::addActions();
        add_filter(self::HOOK_RWMB_META_BOXES, array($this, 'registerRWMBMetaBoxes'));
    }

    public function registerRWMBMetaBoxes(array $metaboxes)
    {
        $metaboxes[] = array(
            'id'       => $this->id,
            'title'    => $this->title,
            'pages'    => $this->screens,
            'context'  => $this->context,
            'priority' => $this->priority,
            'fields'   => $this->describeFields()
        );
        return $metaboxes;
    }

    private function describeFields()
    {

    }

    public function display($post)
    {

    }

    public function register()
    {

    }

} 