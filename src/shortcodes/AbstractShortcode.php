<?php

namespace jvwp\shortcodes;

abstract class AbstractShortcode
{

    private $tags;

    function __construct ($tags = array(), $register = true)
    {
        $this->tags = $tags;
        if ($register) {
            $this->register();
        }
    }

    protected function getDefaultAtts ()
    {
        return array();
    }

    protected function processAtts ($atts = array())
    {
        if (!is_array($atts))
            $atts = array();
        return array_merge($this->getDefaultAtts(), $atts);
    }

    protected function getOutput ($atts, $content)
    {
        return "";
    }

    public final function perform ($atts, $content)
    {
        return $this->getOutput($this->processAtts($atts), $content);
    }

    public function register ()
    {
        foreach ($this->tags as $tag) {
            add_shortcode($tag, array($this, 'perform'));
        }
    }

} 