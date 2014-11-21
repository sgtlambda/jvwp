<?php

namespace jvwp;

use singleton\Singleton;

if(class_exists('Twig_Environment')) {

    class Templates extends Singleton
    {

        private $twigLoader;
        private $twigEnvironment;

        function __construct()
        {
            $this->twigLoader = new \Twig_Loader_Filesystem(array());
            $this->twigEnvironment = new \Twig_Environment($this->twigLoader);
        }

        /**
         * @param string $path
         * @param string $namespace
         * @throws \Twig_Error_Loader
         */
        public function addPath($path, $namespace = \Twig_Loader_Filesystem::MAIN_NAMESPACE)
        {
            $this->twigLoader->addPath($path, $namespace);
        }

        /**
         * @return \Twig_Environment;
         */
        public function getTwigEnvironment()
        {
            return $this->twigEnvironment;
        }

    }

    Templates::setInstance(new Templates());

}