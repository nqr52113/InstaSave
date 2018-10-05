<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;

class Image {
	public $id;
	public $shortcode;
	public $dimensions;
	public $thumbnail;
	public $type = Resource::image;

	public function __construct($image) {
		$this->id = $image->id;
		$this->shortcode = $image->shortcode;
		$this->dimensions = new Dimension($image->dimensions);
		$this->thumbnail = $image->display_url;
	}
}