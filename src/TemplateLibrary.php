<?php

namespace jvwp;

use FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * Represents a template library that corresponds to a specific path and template namespace
 * @package jvwp
 */
abstract class TemplateLibrary
{

    use SingletonTrait;

    /**
     * The template namespace
     * @var string
     */
    private $templateNamespace;

    /**
     * @param string $templatePath
     * @param string $templateNamespace
     */
    public function __construct ($templatePath, $templateNamespace)
    {
        $this->templateNamespace = $templateNamespace;
        Templates::addPath($templatePath, $this->templateNamespace);
    }

    /**
     * @param string $name The filename of the template
     * @return \Twig_Template
     */
    public static function getTemplate ($name)
    {
        $templateRoot = self::getInstance();
        /* @var $templateRoot \jvwp\TemplateLibrary */
        return Templates::getTemplate('@' . $templateRoot->templateNamespace . '/' . $name);
    }
}