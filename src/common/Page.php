<?php

namespace jvwp\common;

use jvwp\constants\MetaKeys;
use jvwp\constants\PostTypes;
use WP_Post;

class Page
{

    /**
     * Returns an array of WP_Post objects for all of pages that use the given page template
     *
     * @param string $slug
     *
     * @return WP_Post[]
     */
    public static function findByTemplateSlug ($slug)
    {
        return Post::findByExactMeta(MetaKeys::WP_PAGE_TEMPLATE, $slug, PostTypes::PAGE);
    }
}