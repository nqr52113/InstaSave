<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Abstraction\ResponseDecorator;
use InstaSave\Response\Traits\OwnerParser;
use InstaSave\Response\Traits\UserParser;

class User extends ResponseDecorator
{
    use OwnerParser, UserParser;

    /**
     * Parse object that comes from Instagram Response to User Object.
     *
     * @return User
     */
    public function parse()
    {
        return $this->user()->owner();
    }
}
