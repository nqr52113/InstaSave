<?php

namespace InstaSave\Response\Traits;

trait UserParser {
	public $type;
	public $biography;
	public $followedBy;
	public $follow;
	public $isVerified;

	private function user() {
		$this->type = $this->provider->type;
		$this->biography = $this->provider->getBiography();
		$this->followedBy = $this->provider->get('edgeFollowedBy.count');
		$this->follow = $this->provider->get('edgeFollow.count');
		$this->isVerified = $this->provider->getIsVerified();

		return $this;
	}
}