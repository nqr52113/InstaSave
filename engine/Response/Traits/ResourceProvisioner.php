<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Video;
use InstaSave\Response\Model\Image;

trait ResourceProvisioner {
	public $resources;

	private function setResources() {
		if (isset($this->provider->entity->edge_sidecar_to_children->edges)) {
			foreach ($this->provider->entity->edge_sidecar_to_children->edges as $resource) {
				if ($resource->node->is_video) {
					$this->resources[] = new Video($resource->node);
				} else {
					$this->resources[] = new Image($resource->node);
				}
			}
		}

		if ($this->provider->entity->is_video) {
			$this->resources[] = new Video($this->provider->entity);
		} else {
			$this->resources[] = new Image($this->provider->entity);
		}

		return $this;
	}
}