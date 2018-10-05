<?php

namespace InstaSave\URL\Abstraction;

abstract class URLProvider {
	public $url;

	public function __construct(String $url) {
		$this->absoluteUrl = $url;

		$this->validate();
	}

	abstract protected function validate();
}
