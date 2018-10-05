<?php

namespace InstaSave\Response\Model;

class Dimension {
	public $width;
	public $height;

	public function __construct($dimensions) {
		$this->width = $dimensions->width;
		$this->height = $dimensions->height;
	}
}