<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */

namespace jvwp\admin\pages;

class AdminPageMode
{

    /**
     * @var string
     */
    private $slug;

    /**
     * @var callable
     */
    private $init;

    /**
     * @var callable
     */
    private $render;

    /**
     * AdminPageMode constructor.
     *
     * @param string   $slug
     * @param callable $init   A function that is triggered on the admin_init hook
     * @param callable $render The function that renders the page
     */
    public function __construct ($slug, $init = null, $render = null)
    {
        $this->slug          = $slug;
        $this->init          = $init;
        $this->render        = $render;
    }

    /**
     * @return string
     */
    public function getSlug ()
    {
        return $this->slug;
    }

    /**
     * @return callable
     */
    public function getInitFunc ()
    {
        return $this->init;
    }

    /**
     * @return callable
     */
    public function getRenderFunc ()
    {
        return $this->render;
    }
}