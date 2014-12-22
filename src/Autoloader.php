<?php

namespace jvwp;

class Autoloader
{

    private $namespace;
    private $dir;

    /**
     * @param string $namespace Usually <code>__NAMESPACE__</code>
     * @param string $dir       Usually <code>__DIR__</code>
     */
    public function __construct ($namespace, $dir)
    {
        $this->namespace = $namespace;
        $this->dir       = $dir;
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass($class) {
        $prefix = $this->namespace . '\\';
        $base_dir = $this->dir . '/';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0)
            return;
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file))
            require $file;
    }

}