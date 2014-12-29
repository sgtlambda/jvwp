<?php

namespace jvwp\widgets;

abstract class Widget extends \WP_Widget
{

    public function __construct ($id_base, $name, $widget_options = array(), $control_options = array(), $register = true)
    {
        parent::__construct($id_base, $name, $widget_options, $control_options);
        if ($register)
            add_action('widgets_init', array($this, 'registerWidgetClass'));
    }

    public function registerWidgetClass ()
    {
        register_widget(get_class($this));
    }
}