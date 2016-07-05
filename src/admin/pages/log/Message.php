<?php

namespace jvwp\admin\pages\log;

class Message
{

    const TYPE_SUCCESS = 'success';
    const TYPE_INFO    = 'info';
    const TYPE_WARN    = 'warn';
    const TYPE_FATAL   = 'fatal';

    private $time;
    private $type;
    private $short;
    private $detailed;

    /**
     * Creates a new log message
     *
     * @param string $type     The type of message
     * @param string $short    A short description of what happened
     * @param string $detailed An optional detailed description of what happened
     */
    function __construct ($type, $short, $detailed = "")
    {
        $this->type     = $type;
        $this->short    = $short;
        $this->detailed = $detailed;
        $this->time     = time();
    }

    /**
     * Renders the log message to HTML markup
     * @return string
     */
    public function render ()
    {
        $short    = !empty($this->detailed) ? "<p><strong>{$this->short}</strong></p>" : "<p>{$this->short}</p>";
        $detailed = !empty($this->detailed) ? "<p>{$this->detailed}</p>" : "";
        $classes  = implode(' ', $this->getClasses());
        return '<div class="' . $classes . '">' . $short . $detailed . '</div>';
    }

    protected function getClasses ()
    {
        $classes = [
            'jvwp-admin',
            'log',
            'message',
            'type-' . $this->type,
            'notice'
        ];
        if ($this->type === self::TYPE_SUCCESS)
            $classes[] = 'notice-success';
        if ($this->type === self::TYPE_INFO)
            $classes[] = 'notice-info';
        if ($this->type === self::TYPE_WARN)
            $classes[] = 'notice-warning';
        if ($this->type === self::TYPE_FATAL)
            $classes[] = 'notice-error';
        return $classes;
    }
}