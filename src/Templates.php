<?php

namespace jvwp;

use FlorianWolters\Component\Util\Singleton\SingletonTrait;

class Templates
{
    use SingletonTrait;

    private $twigLoader;
    private $twigEnvironment;

    function __construct ()
    {
        $this->twigLoader      = new \Twig_Loader_Filesystem(array());
        $this->twigEnvironment = new \Twig_Environment($this->twigLoader);
    }

    /**
     * Adds a path where templates are stored.
     *
     * @param string $path      A path where to look for templates
     * @param string $namespace The namespace to associate the path with
     *
     * @throws \Twig_Error_Loader
     */
    public static function addPath ($path, $namespace = \Twig_Loader_Filesystem::MAIN_NAMESPACE)
    {
        $twigLoader = self::getInstance()->twigLoader;
        /* @var $twigLoader \Twig_Loader_Filesystem */
        $twigLoader->addPath($path, $namespace);
    }

    /**
     * Gets the template with the given name.
     *
     * @param string $name
     *
     * @return \Twig_Template
     */
    public static function getTemplate ($name)
    {
        return self::getInstance()->getTwigEnvironment()->loadTemplate($name);
    }

    /**
     * @return \Twig_Environment;
     */
    public function getTwigEnvironment ()
    {
        return $this->twigEnvironment;
    }
}