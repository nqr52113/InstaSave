<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Abstraction\ResponseDecorator;
use InstaSave\Response\Traits\EntityParser;
use InstaSave\Response\Traits\OwnerParser;
use InstaSave\Response\Traits\ResourceParser;

class Playlist extends ResponseDecorator
{
    use EntityParser, OwnerParser, ResourceParser;

    /**
     * Parse object that comes from Instagram Response to Playlist Object.
     *
     * @return Playlist
     */
    public function parse()
    {
        return $this->entity()->owner()->resources();
    }
}
