<?php

namespace InstaSave\Response\Model;

use InstaSave\Response\Provider\ResponseProvider as Collector;

class Dimension {
	public $width;
	public $height;

	public function __construct(Collector $dimensions) {
		$this->width = $dimensions->getWidth();
		$this->height = $dimensions->getHeight();
	}
}