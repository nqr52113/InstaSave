<?php

namespace InstaSave\Response\Model;

class Owner {
	public $id;
	public $username;
	public $fullname;
	public $avator;

	public function __construct($owner) {
		$this->id = $owner->id;
		$this->username = $owner->username;
		$this->fullname = $owner->full_name;
		$this->avator = $owner->profile_pic_url_hd ?: $owner->profile_pic_url;
	}
}