<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Provider\ModelCollector;

trait OwnerParser
{
    /**
     * The owner of the Entity.
     *
     * @var Owner
     */
    public $owner;

    /**
     * Fill Owner of the Entity.
     *
     * @return InstaSave\Response\Abstraction\ResponseDecorator
     */
    private function owner()
    {
        $owner = $this->provider->getOwner() ?: $this->provider->entity;

        $this->owner = new Owner(new ModelCollector($owner));

        return $this;
    }
}
