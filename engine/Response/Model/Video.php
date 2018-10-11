<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;
use InstaSave\Response\Provider\ResponseProvider as Collector;

class Video {
	public $id;
	public $shortcode;
	public $dimensions;
	public $thumbnail;
	public $video;
	public $duration;
	public $views;
	public $type = Resource::video;

	public function __construct(Collector $video) {
		$this->id = $video->getId();
		$this->shortcode = $video->getShortcode();
		$this->dimensions = new Dimension(new ModelCollector($video->getDimensions()));
		$this->thumbnail = $video->getDisplayUrl();
		$this->video = $video->getVideoUrl();
		$this->duration = (int) $video->getVideoDuration();
		$this->views = $video->getVideoViewCount();
	}
}