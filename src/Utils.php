<?php

namespace jvwp;

use Gregwar\Image\Image;

class Utils
{

    public static function getPostsByType ($post_type = "post", $extraArgs = array())
    {
        $defaultArgs = array(
            'post_type' => $post_type,
            'showposts' => -1,
            'orderby'   => 'title',
            'order'     => 'ASC'
        );
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

    /**
     * Gets the URL of the features image associated with post $post_id or current post
     *
     * @param int|null $post_id
     * @param string   $size
     * @param string   $default
     *
     * @return string
     */
    public static function getThumbnail ($post_id = null, $size = 'full', $default = '')
    {
        $post_id = (null === $post_id) ? get_the_ID() : $post_id;
        if (has_post_thumbnail($post_id)) {
            $meta = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
            return $meta[0];
        } else
            return $default;
    }

    public static function getScaledThumbnail ($post_id = null, $w, $h, $pixelRatio = 1, $size = 'full', $default = '')
    {
        $path = self::getThumbnail($post_id, $size, '');
        if ($path === '')
            return $default;
        return self::getScaledImageUrl($path, $w, $h, $pixelRatio);
    }

    public static function getScaledImageUrl ($path, $w, $h, $pixelRatio = 1)
    {
        $realW = $w * $pixelRatio;
        $realH = $h * $pixelRatio;
        return Image::open($path)
            ->zoomCrop($realW, $realH, 0xfffff)
            ->jpeg(90);
    }

} 