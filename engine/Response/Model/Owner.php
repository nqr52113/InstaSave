<?php

namespace InstaSave\Response\Model;

use InstaSave\Response\Provider\ResponseProvider as Collector;

class Owner {
	public $id;
	public $username;
	public $fullname;
	public $avator;

	public function __construct(Collector $owner) {
		$this->id = $owner->getId();
		$this->username = $owner->getUsername();
		$this->fullname = $owner->getFullName();
		$this->avator = $owner->getProfilePicUrlHd() ?: $owner->getProfilePicUrl();
	}
}