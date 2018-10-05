<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Model\Image;
use InstaSave\Response\Model\Video;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Traits\EntityProvisioner as EntityHandler;
use InstaSave\Response\Traits\OwnerProvisioner as OwnerHandler;
use InstaSave\Response\Traits\ResourceProvisioner as ResourceHandler;
use InstaSave\Response\Abstraction\ResponseDecorator;

class Feed extends ResponseDecorator {
	use EntityHandler, OwnerHandler, ResourceHandler;

	public function make() {
		$this->setEntity()->setOwner()->setResources();
	}
}