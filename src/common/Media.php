<?php

namespace jvwp\common;

use jvwp\constants\Hooks;

/**
 * Image utilities
 * @package jvwp
 */
class Media
{

    /**
     * Hooks into the <pre>upload_mimes</pre> filter, adding the mime types to the array.
     * Takes an associative array of extension => mime-type bindings
     * @param $mimeTypes
     */
    public static function allowUploadsOfType ($mimeTypes)
    {
        add_filter(Hooks::UPLOAD_MIMES,
            function ($m) use ($mimeTypes) {
                return array_merge($m, $mimeTypes);
            });
    }

    /**
     * Adds the svg mime types to the allowed upload types
     */
    public static function allowSvgUploads ()
    {
        self::allowUploadsOfType(array(
            'svg' => 'image/svg+xml'
        ));
    }

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

    /**
     * Resolves URL to a path accessible through the local file system
     *
     * @param $imageUrl
     *
     * @return string
     */
    private static function getPathByUrl ($imageUrl)
    {
        $contentUrl = content_url();
        if (strpos($imageUrl, '/') === 0)
            $imageUrl = self::getRootUrl() . $imageUrl;
        return WP_CONTENT_DIR . str_replace($contentUrl, '', $imageUrl);
    }

    /**
     * Gets the WordPress home root URL
     * @return string
     */
    private static function getRootUrl ()
    {
        if (defined('WP_HOME_ROOT'))
            return WP_HOME_ROOT;
        else
            return home_url();
    }

    /**
     * Gets a relative URL to the post thumbnail, scaled down to the given size
     *
     * @param        $w
     * @param        $h
     * @param int    $pixelRatio
     * @param null   $post_id
     * @param string $size
     * @param string $default
     *
     * @return string
     */
    public static function getScaledThumbnail ($w, $h, $pixelRatio = 1, $post_id = null, $size = 'full', $default = '')
    {
        $path = self::getPathByUrl(self::getThumbnail($post_id, $size, ''));
        if ($path === '')
            return $default;
        return self::getScaledImageUrl($path, $w, $h, $pixelRatio);
    }

    public static function getScaledImageUrl ($path, $w, $h, $pixelRatio = 1)
    {
        $realW = $w * $pixelRatio;
        $realH = $h * $pixelRatio;
        $path  = '/' . \Gregwar\Image\Image::open($path)
                ->zoomCrop($realW, $realH, 0xfffff)
                ->jpeg(90);
        return $path;
    }
}