<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;
use InstaSave\Response\Provider\ResponseProvider as Collector;

class Image {
	public $id;
	public $shortcode;
	public $dimensions;
	public $thumbnail;
	public $type = Resource::image;

	public function __construct(Collector $image) {
		$this->id = $image->getId();
		$this->shortcode = $image->getShortcode();
		$this->dimensions = new Dimension(new ModelCollector($image->getDimensions()));
		$this->thumbnail = $image->getDisplayUrl();
	}
}