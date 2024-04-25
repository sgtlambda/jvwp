<?php

namespace jvwp\components;

class WpFileUploader extends WpMediaUploader
{

    /**
     * Construct a new WpPdfUploader control
     * @param string      $slug
     * @param string      $label
     * @param string      $value
     * @param string|null $title
     * @param string      $buttonText
     * @param string      $libraryType
     * @param boolean     $allowMultiple
     */
    function __construct ($slug, $label = 'Select a file', $value = '', $title = null, $buttonText = 'Select', $libraryType = self::LIBRARY_TYPE_ALL, $allowMultiple = false)
    {
        parent::__construct($slug, $label, $value, $title, $buttonText, $libraryType, $allowMultiple);
    }

    /**
     * @return string
     */
    public function getTemplateLocation ()
    {
        return '@jvwp/wp-file-uploader.html';
    }

    /**
     * @return string
     */
    protected function getAttachmentUrl ()
    {
        return wp_get_attachment_url($this->value);
    }
}