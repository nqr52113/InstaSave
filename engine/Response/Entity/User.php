<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Traits\OwnerParser;
use InstaSave\Response\Traits\UserParser;
use InstaSave\Response\Abstraction\ResponseDecorator;

class User extends ResponseDecorator {
	use OwnerParser, UserParser;

	public function parse() {
		return $this->user()->owner();
	}
}