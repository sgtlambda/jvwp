<?php

namespace jvwp\components;

use fieldwork\components\HiddenField;
use jvwp\common\Media;
use jvwp\Templates;

class WpMediaUploader extends HiddenField
{

    const SIZE_DEFAULT = 50;
    const SIZE_LARGE   = 100;

    /**
     * Image files
     */
    const LIBRARY_TYPE_IMAGE = 'image';

    /**
     * Document / other files
     */

    const LIBRARY_TYPE_APPLICATION = 'application';
    /**
     * All files
     */
    const LIBRARY_TYPE_ALL = '';

    /**
     * @var boolean Whether to allow multiple files
     */
    private $allowMultiple;
    private $title;
    private $buttonText;
    private $libraryType;

    /**
     * @var boolean Whether to forcibly show the label
     */
    private $overrideShowLabel;

    /**
     * The size at which the attachment is retrieved from the server
     * @var string
     */
    private $resolution;

    /**
     * The size at which the images are displayed, in px
     * @var string
     */
    private $displaySize = self::SIZE_DEFAULT;

    /**
     * Construct a new WpMediaUploader control
     * @param string      $slug
     * @param string      $label
     * @param string      $value
     * @param string|null $title
     * @param string      $buttonText
     * @param string      $libraryType
     * @param boolean     $allowMultiple
     */
    function __construct ($slug, $label = 'Select an image', $value = '', $title = null, $buttonText = 'Select', $libraryType = self::LIBRARY_TYPE_IMAGE, $allowMultiple = false)
    {
        parent::__construct($slug, $label, $value);
        $this->image         = $value != '' ? wp_get_attachment_image_src($value) : '';
        $this->title         = $title === null ? $label : $title;
        $this->buttonText    = $buttonText;
        $this->libraryType   = $libraryType;
        $this->allowMultiple = $allowMultiple;
        $this->resolution    = Media::SIZE_THUMBNAIL;
    }

    /**
     * @param boolean $overrideShowLabel
     * @return $this
     */
    public function setOverrideShowLabel ($overrideShowLabel)
    {
        $this->overrideShowLabel = $overrideShowLabel;
        return $this;
    }

    /**
     * Sets the size at which the attachment is retrieved from the server
     * @param string $resolution
     * @return $this
     */
    public function setAttachmentSize ($resolution)
    {
        $this->resolution = $resolution;
        return $this;
    }

    /**
     * Sets the size at which the images are displayed, in px
     * @param string $displaySize
     * @return $this
     */
    public function setDisplaySize ($displaySize)
    {
        $this->displaySize = $displaySize;
        return $this;
    }

    /**
     * Gets the HTML markup of the component
     *
     * @param bool $showLabel
     *
     * @return mixed
     */
    public function getHTML ($showLabel = true)
    {
        return parent::getHTML(false) .
        Templates::getTemplate($this->getTemplateLocation())->render(array(
            'id'          => $this->getId(),
            'showLabel'   => $showLabel || $this->overrideShowLabel,
            'label'       => $this->label,
            'resolution'  => $this->resolution,
            'displaySize' => $this->displaySize
        ));
    }

    private function getAttachment ()
    {
        if (!empty($this->value)) {
            return array(
                'url' => $this->getAttachmentUrl(),
                'id'  => $this->value
            );
        } else
            return null;
    }

    public function getJsonData ()
    {
        return array_merge(parent::getJsonData(), array(
            'attachment'         => $this->getAttachment(),
            'mediaUploaderProps' => array(
                'title'       => $this->title,
                'libraryType' => $this->libraryType,
                'buttonText'  => $this->buttonText,
                'multiple'    => $this->allowMultiple
            )
        ));
    }

    /**
     * @return string
     */
    public function getTemplateLocation ()
    {
        return '@jvwp/wp-media-uploader.html';
    }

    /**
     * @return string
     */
    protected function getAttachmentUrl ()
    {
        return wp_get_attachment_image_src($this->value, $this->resolution)[0];
    }
}