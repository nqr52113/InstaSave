<?php

namespace InstaSave\Response\Traits;

trait UserProvisioner {
	public $type;
	public $biography;
	public $followedBy;
	public $follow;
	public $isVerified;

	private function setUser() {
		$this->type = $this->provider->type;
		$this->biography = $this->provider->entity->biography;
		$this->followedBy = $this->provider->entity->edge_followed_by->count;
		$this->follow = $this->provider->entity->edge_follow->count;
		$this->isVerified = $this->provider->entity->is_verified;

		return $this;
	}
}