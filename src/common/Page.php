<?php

namespace jvwp\common;

use jvwp\constants\MetaKeys;
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
        return self::findByExactMeta(MetaKeys::WP_PAGE_TEMPLATE, $slug);
    }

    /**
     * Finds one or more pages by exactly matching the meta value
     *
     * @param string $meta_key
     * @param string $meta_value
     *
     * @return array
     */
    public static function findByExactMeta ($meta_key, $meta_value)
    {
        return get_posts(array(
            'post_type'  => 'page',
            'meta_key'   => $meta_key,
            'meta_value' => $meta_value
        ));
    }
}