<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Traits\OwnerProvisioner as OwnerHandler;
use InstaSave\Response\Traits\UserProvisioner as UserHandler;
use InstaSave\Response\Abstraction\ResponseDecorator;

class User extends ResponseDecorator {
	use UserHandler, OwnerHandler;

	public function make() {
		$this->setUser()->setOwner();
	}
}