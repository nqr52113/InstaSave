<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Video;
use InstaSave\Response\Model\Image;
use InstaSave\Exception\ResponseException;
use InstaSave\Response\Provider\ModelCollector;

trait ResourceParser {
	public $resources;

	private function resources() {
		$resources = $this->provider->get('edgeSidecarToChildren.edges') ?: [];
		
		foreach ($resources as $resource) {
			if (!isset($resource->node->is_video)) {
				continue;
			}

			if ($resource->node->is_video == true) {
				$this->resources[] = new Video(new ModelCollector($resource->node));
				continue;
			}
			
			$this->resources[] = new Image(new ModelCollector($resource->node));
		}

		if ($this->provider->getIsVideo()) {
			$this->resources[] = new Video(new ModelCollector($this->provider->entity));
		} else {
			$this->resources[] = new Image(new ModelCollector($this->provider->entity));
		}

		if (!$this->resources) {
			throw new ResponseException('Response Expect Resources from Entity', 500);
		}

		return $this;
	}
}