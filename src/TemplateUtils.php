<?php

namespace jvwp;

use Twig_Error_Loader;

class TemplateUtils
{

    private static function normalizeName ($name)
    {
        return preg_replace('#/{2,}#', '/', strtr((string)$name, '\\', '/'));
    }

    private static function validateName ($name)
    {
        if (false !== strpos($name, "\0")) {
            throw new Twig_Error_Loader('A template name cannot contain NUL bytes.');
        }

        $name  = ltrim($name, '/');
        $parts = explode('/', $name);
        $level = 0;
        foreach ($parts as $part) {
            if ('..' === $part) {
                --$level;
            } elseif ('.' !== $part) {
                ++$level;
            }

            if ($level < 0) {
                throw new Twig_Error_Loader(sprintf('Looks like you try to load a template outside configured directories (%s).', $name));
            }
        }
    }

    private static function parseName ($name, $default = \Twig_Loader_Filesystem::MAIN_NAMESPACE)
    {
        if (isset($name[0]) && '@' == $name[0]) {
            if (false === $pos = strpos($name, '/')) {
                throw new Twig_Error_Loader(sprintf('Malformed namespaced template name "%s" (expecting "@namespace/template_name").', $name));
            }

            $namespace = substr($name, 1, $pos - 1);
            $shortname = substr($name, $pos + 1);

            return array($namespace, $shortname);
        }

        return array($default, $name);
    }

    /**
     * Determine the path of a template based on its name
     *
     * @param \Twig_Loader_Filesystem $filesystem
     * @param string                  $name
     *
     * @return string
     *
     * @throws Twig_Error_Loader
     */
    public static function findTemplate (\Twig_Loader_Filesystem $filesystem, $name)
    {
        $name = self::normalizeName($name);
        self::validateName($name);
        list($namespace, $shortname) = self::parseName($name);
        $paths = $filesystem->getPaths($namespace);
        if (empty($paths)) {
            throw new Twig_Error_Loader(sprintf('There are no registered paths for namespace "%s".', $namespace));
        }
        foreach ($paths as $path) {
            if (is_file($path . '/' . $shortname)) {
                if (false !== $realpath = realpath($path . '/' . $shortname)) {
                    return $realpath;
                }
                return $path . '/' . $shortname;
            }
        }
        throw new Twig_Error_Loader(sprintf('Unable to find template "%s" (looked into: %s).', $name, implode(', ', $paths)));
    }
}