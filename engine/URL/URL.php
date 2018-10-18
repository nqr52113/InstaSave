<?php

namespace InstaSave\URL;

use InstaSave\Exception\URLValidationException;
use InstaSave\URL\Abstraction\URLProvider;

class URL extends URLProvider
{
    /**
     * Validate URL and then send Request.
     *
     * @return URLValidationException
     */
    protected function validate()
    {
        $pattern = '/^(http|https)\:\/\/(www\.)*?instagram.com(\/[\w\+\=\?\&\/\.\-]+)$/i';

        if (!preg_match($pattern, $this->absoluteUrl)) {
            throw new URLValidationException('Invalid Instagram URL.', 500);
        }
    }
}
