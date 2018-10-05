<?php

namespace InstaSave\URL;

use InstaSave\URL\Abstraction\URLProvider;
use InstaSave\Exception\URLValidationException;

class URL extends URLProvider {
	protected function validate() {
		$pattern = '/^(http|https)\:\/\/(www\.)*?instagram.com(\/[\w\+\=\?\&\/\.\-]+)$/i';

		if (!preg_match($pattern, $this->absoluteUrl)) {
			throw new URLValidationException('Invalid Instagram URL.', 500);
		}

		return true;
	}
}
