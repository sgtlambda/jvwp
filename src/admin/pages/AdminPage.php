<?php

namespace jvwp\admin\pages;

use Exception;
use jmversteeg\crudalicious\view\ModeBasedUrlProvider;
use jvwp\admin\pages\log\Message;
use jvwp\constants\Hooks;

/**
 * Represents a page in the admin backend
 *
 * @package fibernet\wp\admin
 */
abstract class AdminPage implements ModeBasedUrlProvider
{

    const MODE_DEFAULT = 'default';

    const USER_FUNC_DISPLAY = 'display';
    const USER_FUNC_INIT    = 'init';

    /**
     * @var AdminPageMode[]
     */
    protected $modes;

    protected $pageTitle;
    protected $menuTitle;
    protected $capability;
    protected $menuSlug;

    /**
     * An array of log messages do display on this page
     *
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
     * Redirect to the default view
     *
     * @param ModeBasedUrlProvider $urlProvider
     */
    public static function resetView (ModeBasedUrlProvider $urlProvider)
    {
        $redirectHeader = 'Location: ' . $urlProvider->getModeUrl(self::MODE_DEFAULT);
        header($redirectHeader);
        exit;
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
     *
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
     * Sets up the WP hooks
     */
    protected function addActions ()
    {
        add_action(Hooks::ADMIN_MENU, array($this, 'addPage'));
        if ($this->currentlyOnPage()) {
            add_action(Hooks::ADMIN_INIT, [$this, 'adminInit']);
        }
    }

    /**
     * Performs a user func on the active mode
     *
     * @param callable $getMode A callable that retrieves the user func from the mode
     * @throws Exception
     */
    private function doUserFunc ($getMode)
    {
        if (($activeMode = $this->getActiveMode()) !== null && ($userFunc = call_user_func($getMode, $activeMode)) !== null) {
            call_user_func($userFunc, $activeMode);
        }
    }

    /**
     * Called upon the <pre>admin_init</pre> hook if this page is active
     */
    public function adminInit ()
    {
        set_current_screen($this->menuSlug);
        $this->doUserFunc(function (AdminPageMode $mode) {
            return $mode->getInitFunc();
        });
    }

    /**
     * Gets the callable array pointing to this object's display method
     *
     * @return array
     */
    protected function getDisplayFunction ()
    {
        return [$this, 'wrap'];
    }

    /**
     * Wraps the page. This method should reference the <pre>page()</pre> method
     */
    public function wrap ()
    {
        echo '<div class="wrap">';
        $this->page();
        echo '</div>';
    }

    /**
     * Display the page header
     */
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
     * Invokes the relevant WordPress function to add the page
     */
    public abstract function addPage ();

    /**
     * Displays the page
     */
    public function display ()
    {
        $this->doUserFunc(function (AdminPageMode $mode) {
            return $mode->getRenderFunc();
        });
    }

    /**
     * Gets the URL at which this page is visible
     *
     * @return string
     */
    public function getUrl ()
    {
        return admin_url('admin.php?page=' . $this->menuSlug);
    }

    /**
     * Gets the URL for a specific mode of this Crud Interface
     *
     * @param string $modeSlug
     *
     * @return string
     */
    public function getModeUrl ($modeSlug)
    {
        return $this->getUrl() . '&mode=' . $modeSlug;
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
        echo '</div>';
        echo '</div>';
    }

    /**
     * Removes a display mode
     *
     * @param AdminPageMode|string $mode
     */
    public function removeMode ($mode)
    {
        if ($mode instanceof AdminPageMode)
            $mode = $mode->getSlug();
        unset($this->modes[$mode]);
    }

    /**
     * Adds a new display mode, which can be requested through the URL parameter <pre>mode</pre>
     *
     * @param AdminPageMode $mode
     */
    public function addMode (AdminPageMode $mode)
    {
        $this->modes[$mode->getSlug()] = $mode;
    }

    /**
     * @return string
     */
    protected function getActiveModeSlug ()
    {
        if ($this->modes === null)
            return null;
        $mode = array_key_exists('mode', $_GET) ? $_GET['mode'] : $this->getDefaultModeSlug();
        if (!array_key_exists($mode, $this->modes))
            $mode = $this->getDefaultModeSlug();
        return $mode;
    }

    /**
     * @return AdminPageMode
     */
    protected function getActiveMode ()
    {
        $activeModeSlug = $this->getActiveModeSlug();
        if ($activeModeSlug === null)
            return null;
        return $this->modes[$activeModeSlug];
    }

    /**
     * Set the active mode
     *
     * @param AdminPageMode|string $mode Mode or mode slug
     */
    protected function setActiveMode ($mode)
    {
        if ($mode instanceof AdminPageMode)
            $mode = $mode->getSlug();
        $_GET['mode'] = $mode;
    }

    /**
     * Gets the slug of the default mode
     *
     * @return string
     */
    protected function getDefaultModeSlug ()
    {
        return AdminPage::MODE_DEFAULT;
    }

    /**
     * @return string
     */
    public function getMenuSlug ()
    {
        return $this->menuSlug;
    }
}