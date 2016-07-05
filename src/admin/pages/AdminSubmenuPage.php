<?php

namespace jvwp\admin\pages;

abstract class AdminSubmenuPage extends AdminPage
{

    private $parentSlug;

    function __construct ($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug)
    {
        parent::__construct($pageTitle, $menuTitle, $capability, $menuSlug);
        $this->parentSlug = $parentSlug;
    }

    /**
     * Invokes the WordPress function <pre>add_submenu_page</pre>
     */
    public function addPage ()
    {
        add_submenu_page($this->parentSlug, $this->pageTitle, $this->menuTitle, $this->capability, $this->menuSlug, $this->getDisplayFunction());
    }
}