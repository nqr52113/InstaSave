<?php

namespace InstaSave\Response\Abstraction;

use JsonSerializable;
use InstaSave\Response\Contract\Response;

abstract class ResponseDecorator implements Response, JsonSerializable
{
    /**
     * Contains Response Provider Collector like EntityCollector,
     * These Collector must use Response Contract.
     * 
     * @var Response
     */
    protected $provider;

    /**
     * Constructor of Decorator.
     *
     * @param Response $provider
     */
    public function __construct(Response $provider) {
        $this->provider = $provider;
    }

    /**
     * what to Serialize when json_encode call?
     *
     * @return ResponseDecorator
     */
    public function jsonSerialize() {
        return $this;
    }

    /**
     * Parse object that comes from Instagram Response to InstaSave Entity Classes.
     *
     * @return Response
     */
    abstract public function parse();
}