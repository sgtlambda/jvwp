<?php

namespace jvwp;

class Utils
{

    public static function getPostsByType($post_type = "post", $extraArgs = array())
    {
        $defaultArgs = array(
            'post_type' => $post_type,
            'showposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        $args = array_merge($defaultArgs, $extraArgs);
        return get_posts($args);
    }

    /**
     * @param int $id
     * @param callable $callback
     * @param array $params
     * @return \WP_Post | null WP_Post on success or null on failure
     */
    public static function displaySingleItemByID($id, $callback = null, array $params = array())
    {
        global $post;
        $post = get_post($id);
        if (!is_null($post)) {
            setup_postdata($post);
            if ($callback !== null)
                call_user_func_array($callback, array_merge(array($post), $params));
            wp_reset_postdata();
        }
        return $post;
    }

    /**
     * @param string $post_type
     * @param array $args
     * @param null $callback
     * @param array $params
     * @return \WP_Query
     */
    public static function displayItems($post_type = 'any', array $args = array(), $callback = null, array $params = array())
    {
        $query = new \WP_Query(array_merge(array(
            'post_type' => $post_type
        ), $args));
        if ($query->have_posts()) {
            global $post;
            while ($query->have_posts()) {
                $query->the_post();
                if ($callback !== null)
                    call_user_func_array($callback, array_merge(array($post), $params));
            }
            wp_reset_postdata();
        }
        return $query;
    }

    public static function getFeaturedImageUrl($post_id = null, $size = 'full', $default = '')
    {
        $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
        if (has_post_thumbnail($post_id)) {
            $meta = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
            return $meta[0];
        } else
            return $default;
    }

} 