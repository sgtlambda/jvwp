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
     * @param string $path
     * @param string $namespace
     *
     * @throws \Twig_Error_Loader
     */
    public static function addPath ($path, $namespace = \Twig_Loader_Filesystem::MAIN_NAMESPACE)
    {
        self::getInstance()->twigLoader->addPath($path, $namespace);
    }

    /**
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