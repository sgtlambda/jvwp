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

        $this->addActions();
    }

    public function currentlyOnPage ()
    {
        $pageParam = array_key_exists('page', $_GET) ? $_GET['page'] : '';
        return $pageParam === $this->menuSlug;
    }

    /**
     * Adds a message to the log
     *
     * @param Message $message
     */
    public function log (Message $message)
    {
        $this->log[] = $message;
    }

    /**
     * Gets the HTML markup to display of all consecutive log messages
     * @return string
     */
    public function renderLog ()
    {
        $output = '';
        foreach ($this->log as $message)
            $output .= $message->render();
        return $output;
    }

    /**
     * Sets up the hooks
     */
    protected function addActions ()
    {
        add_action(Hooks::ADMIN_MENU, array($this, 'addPage'));
        if ($this->currentlyOnPage()) {
            add_action(Hooks::ADMIN_INIT, array($this, 'adminInit'));
        }
    }

    /**
     * Called upon the <pre>admin_init</pre> hook if this page is active
     */
    public function adminInit ()
    {
        set_current_screen($this->menuSlug);
    }

    /**
     * Gets the callable array pointing to this object's display method
     * @return array
     */
    protected function getDisplayFunction ()
    {
        return array($this, 'wrap');
    }

    /**
     * Displays the outer wrapper
     */
    public function wrap ()
    {
        echo '<div class="wrap">';
        $this->page();
        echo '</div>';
    }

    public function displayHeader ()
    {
        echo '<h2>' . $this->pageTitle;
        $this->displayHeaderButton();
        echo '</h2>';
    }

    /**
     * Display a button in the top-right of the page
     */
    protected function displayHeaderButton ()
    {

    }

    /**
     * Invokes the relevant wordpress function to add the page
     */
    public abstract function addPage ();

    /**
     * Displays the page
     */
    public abstract function display ();

    /**
     * Gets the URL at which this page is visible
     * @return string
     */
    public function getUrl ()
    {
        return admin_url('admin.php?page=' . $this->menuSlug);
    }

    /**
     * Displays the content within the div#wrap
     */
    protected function page ()
    {
        $this->displayHeader();
        echo $this->renderLog();
        $this->display();
    }

    /**
     * Displays the main / side layout skeleton, invoking the two callbacks for displaying their respective parts
     *
     * @param ProvidesSkeletonContent $content
     */
    public static function doSkeleton (ProvidesSkeletonContent $content)
    {
        echo '<div id="poststuff">';
        echo '<div id="post-body" class="metabox-holder columns-2">';

        echo '<div id="post-body-content" style="position: relative;">';
        $content->renderBody();
        echo '</div>';

        echo '<div id="postbox-container-1" class="postbox-container">';
        $content->renderSide();
        echo '</div>';

        echo '</div>'; // ends post-body
        echo '</div>'; // ends poststuff
    }
}