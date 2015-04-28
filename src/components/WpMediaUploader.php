<?php

namespace jvwp\components;

use fieldwork\components\HiddenField;
use jvwp\common\Media;
use jvwp\Templates;

class WpMediaUploader extends HiddenField
{

    const SIZE_DEFAULT = 50;
    const SIZE_LARGE   = 100;

    const TEMPLATE_MEDIA_UPLOADER = '@jvwp/wp-media-uploader.html';

    const LIBRARY_TYPE_IMAGE = 'image';

    /**
     * @var boolean
     */
    private $allowMultiple;
    private $title;
    private $buttonText;
    private $libraryType;

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
     * Sets the size at which the attachment is retrieved from the server
     * @param string $resolution
     */
    public function setAttachmentSize ($resolution)
    {
        $this->resolution = $resolution;
    }

    /**
     * Sets the size at which the images are displayed, in px
     * @param string $displaySize
     */
    public function setDisplaySize ($displaySize)
    {
        $this->displaySize = $displaySize;
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
        Templates::getTemplate(self::TEMPLATE_MEDIA_UPLOADER)->render(array(
            'id'          => $this->getId(),
            'showLabel'   => $showLabel,
            'label'       => $this->label,
            'resolution'  => $this->resolution,
            'displaySize' => $this->displaySize
        ));
    }

    private function getAttachment ()
    {
        if (!empty($this->value)) {
            $imageSrc = wp_get_attachment_image_src($this->value, $this->resolution);
            return array(
                'url' => $imageSrc[0],
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
}