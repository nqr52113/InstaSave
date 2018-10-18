<?php

namespace InstaSave\URL\Abstraction;

abstract class URLProvider
{
    /**
     * The URL that we want to send request.
     *
     * @var string
     */
    public $absoluteUrl;

    /**
     * Constructor of URL.
     *
     * @param string $url
     */
    public function __construct(String $url)
    {
        $this->absoluteUrl = $url;

        $this->validate();
    }

    /**
     * Validate URL and then send Request.
     *
     * @return URLValidationException
     */
    abstract protected function validate();
}
