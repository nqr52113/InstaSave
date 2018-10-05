<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;

class Video {
	public $id;
	public $shortcode;
	public $dimensions;
	public $thumbnail;
	public $video;
	public $duration;
	public $views;
	public $type = Resource::video;

	public function __construct($video) {
		$this->id = $video->id;
		$this->shortcode = $video->shortcode;
		$this->dimensions = new Dimension($video->dimensions);
		$this->thumbnail = $video->display_url;
		$this->video = $video->video_url;
		$this->duration = isset($video->video_duration) ? $video->video_duration : 0;
		$this->views = $video->video_view_count;
	}
}