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

    /**
     * Get an array of default attributes
     * @return array
     */
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

    /**
     * Gets the output of the shortcode
     * @param array  $atts
     * @param string $content
     * @return string
     */
    public function getOutput ($atts = array(), $content = '')
    {
        return "";
    }

    public final function perform ($atts, $content)
    {
        return $this->getOutput($this->processAtts($atts), $content);
    }

    /**
     * Registers the shortcode with WP
     */
    public function register ()
    {
        foreach ($this->tags as $tag) {
            add_shortcode($tag, array($this, 'perform'));
        }
    }

} 