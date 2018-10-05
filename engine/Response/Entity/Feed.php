<?php

namespace InstaSave\Response\Entity;

use InstaSave\Response\Model\Owner;
use InstaSave\Response\Model\Image;
use InstaSave\Response\Model\Video;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Abstraction\ResponseDecorator;

class Feed extends ResponseDecorator {
	public $id;
	public $type;
	public $shortcode;
	public $dimensions;
	public $comments;
	public $likes;
	public $postedAt;
	public $description;
	public $owner;
	public $resources;

	public function make() {
		$this->id = $this->provider->entity->id;
		$this->type = $this->provider->type;
		$this->shortcode = $this->provider->entity->shortcode;
		$this->comments = $this->provider->entity->edge_media_to_comment->count;
		$this->likes = $this->provider->entity->edge_media_preview_like->count;
		$this->postedAt = $this->provider->entity->taken_at_timestamp;
		$this->description = $this->provider->entity->edge_media_to_caption->edges[0]->node->text ?: null;
		$this->dimensions = new Dimension($this->provider->entity->dimensions);
		$this->owner = new Owner($this->provider->entity->owner);
		
		if ($this->provider->entity->is_video) {
			$this->resources[] = new Video($this->provider->entity);
		} else {
			$this->resources[] = new Image($this->provider->entity);
		}
	}
}