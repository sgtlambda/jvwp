<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */

namespace jvwp\admin\pages;

interface ProvidesSkeletonContent
{

    /**
     * Renders the main body
     */
    public function renderBody ();

    /**
     * Renders the side bar content
     */
    public function renderSide ();
}