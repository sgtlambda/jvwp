<?php

namespace jvwp\common;

class Utils
{

    /**
     * Gets an array of WP_Post objects based on the provided type(s)
     *
     * @param string|array $post_type    Post type or post types
     * @param array        $extraArgs    Optional array of extra arguments to pass to get_posts
     * @param bool         $orderByTitle Whether to order by title in ascending order
     *
     * @return array
     */
    public static function getPostsByType ($post_type = "post", $extraArgs = array(), $orderByTitle = true)
    {
        $defaultArgs = array_merge(array(
            'post_type' => $post_type,
            'showposts' => -1
        ), $orderByTitle ? array(
            'orderby' => 'title',
            'order'   => 'ASC') : array());
        $args        = array_merge($defaultArgs, $extraArgs);
        return get_posts($args);
    }

    /**
     * @param int      $id
     * @param callable $callback
     * @param array    $callback_params
     *
     * @return \WP_Post | null WP_Post on success or null on failure
     */
    public static function displaySingleItemByID ($id, $callback = null, array $callback_params = array())
    {
        $item = get_post($id);
        if (!is_null($item)) {
            global $post;
            $post = $item;
            setup_postdata($post);
            if ($callback !== null)
                call_user_func_array($callback, array_merge(array($post), $callback_params));
            wp_reset_postdata();
        }
        return $item;
    }

    /**
     * @param string $post_type
     * @param array  $args
     * @param null   $callback
     * @param array  $params
     *
     * @return \WP_Query
     */
    public static function displayItems ($post_type = 'any', array $args = array(), $callback = null, array $params = array())
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
}