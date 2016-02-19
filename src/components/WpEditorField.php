<?php

namespace jvwp\components;

use fieldwork\components\Textarea;

/**
 * Fieldwork Field implementation of the wp_editor function
 */
class WpEditorField extends Textarea
{

    private $editorOptions = [];

    const OPTION_EDITOR_CLASS     = 'editor_class';
    const OPTION_DRAG_DROP_UPLOAD = 'drag_drop_upload';
    const OPTION_WPAUTOP          = 'wpautop';
    const OPTION_TEENY            = 'teeny';

    public function getHTML ($showLabel = true)
    {
        // Capture the output of the WordPress API function using output buffering
        ob_start();
        wp_editor($this->value, $this->getName(), $this->getEditorOptions());
        return ob_get_clean();
    }

    public function setOption ($option, $value)
    {
        $this->editorOptions[$option] = $value;
    }

    /**
     * Gets an array of options passed to <pre>wp_editor</pre>
     * @return array
     */
    private function getEditorOptions ()
    {
        return array_merge([
            self::OPTION_EDITOR_CLASS     => implode(' ', $this->getClasses()),
            self::OPTION_DRAG_DROP_UPLOAD => true
        ], $this->editorOptions);
    }
}