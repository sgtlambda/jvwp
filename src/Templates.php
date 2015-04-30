<?php

namespace jvwp;

use Cocur\Slugify\Bridge\Twig\SlugifyExtension;
use Cocur\Slugify\Slugify;
use FlorianWolters\Component\Util\Singleton\SingletonTrait;

class Templates
{

    use SingletonTrait;

    private $twigLoader;
    private $twigEnvironment;

    /**
     * Constructs a new template manager
     */
    function __construct ()
    {
        $this->twigLoader      = new \Twig_Loader_Filesystem(array());
        $this->twigEnvironment = new \Twig_Environment($this->twigLoader);

        self::extendTwig($this->twigEnvironment);
    }

    /**
     * Adds the WP-specific filters and functions to the twig environment
     * @param \Twig_Environment $twig_Environment
     */
    private static function extendTwig (\Twig_Environment $twig_Environment)
    {
        $twig_Environment->addFilter('__', new \Twig_SimpleFilter('__', function ($text, $domain = 'default') {
            return __($text, $domain);
        }));
        $twig_Environment->addExtension(new SlugifyExtension(Slugify::create()));
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