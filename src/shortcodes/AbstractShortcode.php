<?php

namespace jvwp\shortcodes;

class AbstractShortcode
{

    private $tags;

    function __construct($tags = array(), $register = true)
    {
        $this->tags = $tags;
        if($register){
            $this->register();
        }
    }

    protected function getDefaultAtts()
    {
        return array();
    }

    protected function processAtts($atts = array())
    {
        return array_merge($atts, $this->getDefaultAtts());
    }

    protected function output($atts, $content) {
        return "";
    }

    public final function perform($atts, $content) {
        return $this->output($this->processAtts($atts), $content);
    }

    public function register()
    {
        foreach ($this->tags as $tag) {
            add_shortcode($tag, array($this, 'perform'));
        }
    }

} 