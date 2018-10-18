<?php

namespace InstaSave\Response\Provider;

use InstaSave\Response\Provider\ResponseProvider;

class ModelCollector extends ResponseProvider
{
    /**
     * constructor of Model Collector.
     *
     * @param object $entity
     */
    public function __construct($entity) {
        $this->entity = $entity;
    }
}