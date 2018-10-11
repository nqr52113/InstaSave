<?php

namespace InstaSave\Response\Abstraction;

use JsonSerializable;
use InstaSave\Response\Contract\Response;

abstract class ResponseDecorator implements Response, JsonSerializable {
	protected $provider;

	public function __construct(Response $provider) {
		$this->provider = $provider;
	}

	public function jsonSerialize() {
		return $this;
	}

	abstract public function parse();
}