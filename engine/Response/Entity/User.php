<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Abstraction\ResponseDecorator;

class User extends ResponseDecorator {
	public $type;
	public $biography;
	public $followedBy;
	public $follow;
	public $isVerified;
	public $owner;

	public function make() {
		$this->type = $this->provider->type;
		$this->biography = $this->provider->entity->biography;
		$this->followedBy = $this->provider->entity->edge_followed_by->count;
		$this->follow = $this->provider->entity->edge_follow->count;
		$this->isVerified = $this->provider->entity->is_verified;
		$this->owner = new Owner($this->provider->entity);
	}
}