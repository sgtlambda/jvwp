<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */


namespace jvwp\admin\pages;


interface ModeBasedUrlProvider
{

    /**
     * Gets the URL for a specific mode of this Interface
     *
     * @param string $modeSlug
     *
     * @return string
     */
    public function getModeUrl ($modeSlug);

    /**
     * Gets the URL at which this page is visible
     *
     * @return string
     */
    public function getUrl ();
}