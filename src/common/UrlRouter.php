<?php

namespace jvwp\common;

use jvwp\constants\Hooks;

/**
 * Utility class that new routes and query vars
 * @package jvwp\common
 */
abstract class UrlRouter
{
    private $routes;
    private $queryVars;

    /**
     * Constructs a new UrlRouter object
     *
     * @param array $routes
     * @param array $queryVars
     */
    function __construct (array $routes = [], array $queryVars = [])
    {
        $this->routes    = $routes;
        $this->queryVars = $queryVars;
        add_action(Hooks::INIT, array($this, 'init'));
    }

    public function init ()
    {
        foreach ($this->getRoutes() as $route => $dest)
            add_rewrite_rule($route, $dest, 'top');
        add_filter('query_vars', function ($queryvars) {
            return array_merge($queryvars, $this->getQueryVars());
        });
    }

    /**
     * Gets a plain array of query vars that will be added to the <pre>query_vars</pre> filter
     * @return array
     */
    protected function getQueryVars ()
    {
        return $this->queryVars;
    }

    /**
     * Gets an array of $route => $destination bindings that will
     * be added using <pre>add_rewrite_rule</pre> during the <pre>init</pre> hook.
     * @return array
     */
    protected function getRoutes ()
    {
        return $this->routes;
    }
}