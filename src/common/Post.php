<?php
/**
 * Copyright (C) Jan-Merijn Versteeg - All Rights Reserved
 * Unauthorized copying of this file, via any medium, is strictly prohibited
 * Proprietary and confidential
 */

namespace jvwp\common;

use jvwp\constants\PostTypes;
use WP_Post;

class Post
{

    /**
     * Finds one or more pages by exactly matching the meta value
     *
     * @param string $meta_key
     * @param string $meta_value
     * @param string $post_type
     *
     * @return \WP_Post[]
     */
    public static function findByExactMeta ($meta_key, $meta_value, $post_type = PostTypes::ANY)
    {
        return get_posts(array(
            'post_type'  => $post_type,
            'meta_key'   => $meta_key,
            'meta_value' => $meta_value
        ));
    }
}