<?php

namespace jvwp\shortcodes;

if(class_exists('Twig_Template')) {

    class TemplateShortcode extends AbstractShortcode
    {

        private $template;

        function __construct(\Twig_Template $template = null, $tags = array(), $register = true)
        {
            $this->template = $template;
            parent::__construct($tags, $register);
        }

        public function getOutput($atts = array(), $content = '')
        {
            return $this->template->render(array(
                'content' => $content,
                'attr' => $atts
            ));
        }


    }

}