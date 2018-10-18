<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Traits\EntityParser;
use InstaSave\Response\Traits\OwnerParser;
use InstaSave\Response\Traits\ResourceParser;
use InstaSave\Response\Abstraction\ResponseDecorator;

class Feed extends ResponseDecorator
{
    use EntityParser, OwnerParser, ResourceParser;

    /**
     * Parse object that comes from Instagram Response to Feed Object.
     *
     * @return Feed
     */
    public function parse() {
        return $this->entity()->owner()->resources();
    }
}