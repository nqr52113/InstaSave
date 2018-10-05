<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Owner;

trait OwnerProvisioner {
	public $owner;

	private function setOwner() {
		$owner = isset($this->provider->entity->owner) ? $this->provider->entity->owner : $this->provider->entity;
		
		$this->owner = new Owner($owner);

		return $this;
	}
}