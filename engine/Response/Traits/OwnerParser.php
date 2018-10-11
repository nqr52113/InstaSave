<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Provider\ModelCollector;

trait OwnerParser {
	public $owner;

	private function owner() {
		$owner = $this->provider->getOwner() ?: $this->provider->entity;

		$this->owner = new Owner(new ModelCollector($owner));

		return $this;
	}
}