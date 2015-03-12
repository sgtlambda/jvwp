<?php

namespace jvwp\common;

/**
 * Image utilities
 * @package jvwp
 */
class Image
{

    /**
     * Gets the URL of the features image associated with post $post_id or current post
     *
     * @param int|null $post_id
     * @param string   $size Optional size argument. Defaults to full
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

    public static function getScaledThumbnail ($w, $h, $pixelRatio = 1, $post_id = null, $size = 'full', $default = '')
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
        return '/' . \Gregwar\Image\Image::open($path)
            ->zoomCrop($realW, $realH, 0xfffff)
            ->jpeg(90);
    }
}