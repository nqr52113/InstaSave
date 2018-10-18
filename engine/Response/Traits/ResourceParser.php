<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Video;
use InstaSave\Response\Model\Image;
use InstaSave\Exception\ResponseException;
use InstaSave\Response\Provider\ModelCollector;

trait ResourceParser
{
    /**
     * Resources of the Entity Images and Videos.
     *
     * @var array
     */
    public $resources;

    /**
     * Find all resources for Entity.
     *
     * @return InstaSave\Response\Abstraction\ResponseDecorator | ResponseException
     */
    private function resources() {
        // if the Entity was Playlist then it will get all Videos and Images array
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