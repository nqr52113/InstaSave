<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;
use InstaSave\Response\Provider\ResponseProvider as Collector;

class Video 
{
    /**
     * Resource ID.
     *
     * @var int
     */
    public $id;

    /**
     * Resource Shortcode.
     *
     * @var string
     */
    public $shortcode;

    /**
     * Resource Dimenstions.
     *
     * @var Dimension
     */
    public $dimensions;

    /**
     * Resource Thumbnail.
     *
     * @var string
     */
    public $thumbnail;

    /**
     * Resource Video.
     *
     * @var string
     */
    public $video;

    /**
     * Duration Resource in second.
     *
     * @var int
     */
    public $duration;

    /**
     * Number of views.
     *
     * @var int
     */
    public $views;

    /**
     * Resource Type.
     *
     * @var Resource
     */
    public $type = Resource::video;

    /**
     * Resource Constructor.
     *
     * @param Collector $video
     */
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