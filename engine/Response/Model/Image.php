<?php

namespace InstaSave\Response\Model;

use InstaSave\Enumeration\Resource;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;
use InstaSave\Response\Provider\ResponseProvider as Collector;

class Image 
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
     * Resource Type.
     *
     * @var Resource
     */
    public $type = Resource::image;

    /**
     * Resource Constructor.
     *
     * @param Collector $image
     */
    public function __construct(Collector $image) {
        $this->id = $image->getId();
        $this->shortcode = $image->getShortcode();
        $this->dimensions = new Dimension(new ModelCollector($image->getDimensions()));
        $this->thumbnail = $image->getDisplayUrl();
    }
}