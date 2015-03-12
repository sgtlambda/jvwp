<?php

namespace jvwp\common;

use jvwp\constants\MetaKeys;

class Page
{

    /**
     * Returns an array of WP_Post objects for all of pages that use the given page template
     *
     * @param string $slug
     *
     * @return array
     */
    public static function findByTemplateSlug ($slug)
    {
        return get_posts(array(
            'post_type'  => 'page',
            'meta_key'   => MetaKeys::WP_PAGE_TEMPLATE,
            'meta_value' => $slug
        ));
    }
}