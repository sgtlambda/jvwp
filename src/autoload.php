<?php

namespace jvwp;

spl_autoload_register(function($className) {
    if(strpos($className, __NAMESPACE__) === 0) {
        $target = dirname(__DIR__) . '/' . $className . '.class.php';
        if (file_exists($target))
            include $target;
    }
});