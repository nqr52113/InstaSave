<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Traits\EntityParser;
use InstaSave\Response\Traits\OwnerParser;
use InstaSave\Response\Traits\ResourceParser;
use InstaSave\Response\Abstraction\ResponseDecorator;

class IGTV extends ResponseDecorator
{
    use EntityParser, OwnerParser, ResourceParser;

    /**
     * Parse object that comes from Instagram Response to IGTV Object.
     *
     * @return IGTV
     */
    public function parse() {
        return $this->entity()->owner()->resources();
    }
}