<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;

trait EntityParser {
	public $id;
	public $type;
	public $shortcode;
	public $dimensions;
	public $comments;
	public $likes;
	public $postedAt;
	public $description;

	private function entity() {
		$this->id = $this->provider->getId();
		$this->type = $this->provider->type;
		$this->shortcode = $this->provider->getShortcode();
		$this->comments = $this->provider->get('edgeMediaToComment.count');
		$this->likes = $this->provider->get('edgeMediaPreviewLike.count');
		$this->postedAt = $this->provider->getTakenAtTimestamp();
		$this->description = $this->provider->get('edgeMediaToCaption.edges#0.node.text');
		$this->dimensions = new Dimension(new ModelCollector($this->provider->getDimensions()));

		return $this;
	}
}