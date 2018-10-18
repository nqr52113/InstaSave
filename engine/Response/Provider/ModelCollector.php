<?php

namespace InstaSave\Response\Provider;

class ModelCollector extends ResponseProvider
{
    /**
     * constructor of Model Collector.
     *
     * @param object $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
