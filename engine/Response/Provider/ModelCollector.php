<?php

namespace InstaSave\Response\Provider;

use InstaSave\Response\Provider\ResponseProvider;

class ModelCollector extends ResponseProvider {
	public function __construct($entity) {
		$this->entity = $entity;
	}
}