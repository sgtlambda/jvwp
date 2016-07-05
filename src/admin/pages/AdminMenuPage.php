<?php

namespace jvwp\admin\pages;

abstract class AdminMenuPage extends AdminPage
{

    private $icon;
    private $order;

    function __construct ($pageTitle, $menuTitle, $capability, $menuSlug, $order = 20, $icon = '')
    {
        parent::__construct($pageTitle, $menuTitle, $capability, $menuSlug);
        $this->order = $order;
        $this->icon  = $icon;
    }

    /**
     * Invokes the WordPress function <pre>add_menu_page</pre>
     */
    public function addPage ()
    {
        add_menu_page($this->pageTitle, $this->menuTitle, $this->capability, $this->menuSlug, $this->getDisplayFunction(), $this->icon, $this->order);
    }
}