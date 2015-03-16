<?php

namespace jvwp\admin\pages;

use jvwp\admin\pages\log\Message;
use jvwp\constants\Hooks;

/**
 * Represents a page in the admin backend
 * @package fibernet\wp\admin
 */
abstract class AdminPage
{

    protected $pageTitle;
    protected $menuTitle;
    protected $capability;
    protected $menuSlug;

    /**
     * An array of log messages do display on this page
     * @var Message[]
     */
    private $log;

    /**
     * Constructs and registers a admin page. Be sure to invoke **before** the <pre>admin_menu</pre> hook.
     *
     * @param string $pageTitle
     * @param string $menuTitle
     * @param string $capability
     * @param string $menuSlug
     */
    function __construct ($pageTitle, $menuTitle, $capability, $menuSlug)
    {
        $this->pageTitle  = $pageTitle;
        $this->menuTitle  = $menuTitle;
        $this->capability = $capability;
        $this->menuSlug   = $menuSlug;
        $this->log        = array();

        $this->setup();
    }

    /**
     * Adds a message to the log
     * @param Message $message
     */
    public function log(Message $message)
    {
        $this->log[] = $message;
    }

    /**
     * Gets the HTML markup to display of all consecutive log messages
     * @return string
     */
    public function renderLog()
    {
        $output = '';
        foreach($this->log as $message)
            $output .= $message->render();
        return $output;
    }

    /**
     * Internal method to set up <pre>admin_menu</pre> hook
     */
    private function setup ()
    {
        add_action(Hooks::ADMIN_MENU, array($this, 'addPage'));
    }

    /**
     * Gets the callable array pointing to this object's display method
     * @return array
     */
    protected function getDisplayFunction ()
    {
        return array($this, 'wrap');
    }

    public function wrap ()
    {
        echo '<div class="wrap">';
        $this->displayHeader();
        echo $this->renderLog();
        $this->display();
        echo '</div>';
    }

    public function displayHeader ()
    {
        echo '<h2>' . $this->pageTitle . '</h2>';
    }

    /**
     * Invokes the relevant wordpress function to add the page
     */
    public abstract function addPage ();

    public abstract function display ();

    /**
     * Gets the URL at which this page is visible
     * @return string
     */
    public function getUrl() {
        return admin_url('admin.php?page=' . $this->menuSlug);
    }
}