<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Dimension;

trait EntityProvisioner {
	public $id;
	public $type;
	public $shortcode;
	public $dimensions;
	public $comments;
	public $likes;
	public $postedAt;
	public $description;

	private function setEntity() {
		$this->id = $this->provider->entity->id;
		$this->type = $this->provider->type;
		$this->shortcode = $this->provider->entity->shortcode;
		$this->comments = $this->provider->entity->edge_media_to_comment->count;
		$this->likes = $this->provider->entity->edge_media_preview_like->count;
		$this->postedAt = $this->provider->entity->taken_at_timestamp;
		$this->description = $this->provider->entity->edge_media_to_caption->edges[0]->node->text ?: null;
		$this->dimensions = new Dimension($this->provider->entity->dimensions);

		return $this;
	}
}