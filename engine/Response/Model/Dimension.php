<?php

namespace InstaSave\Response\Model;

use InstaSave\Response\Provider\ResponseProvider as Collector;

class Dimension
{
    /**
     * Width of the Resource or Entity.
     *
     * @var int
     */
    public $width;

    /**
     * Height of the Resource or Entity.
     *
     * @var int
     */
    public $height;

    /**
     * Constructor of Dimention.
     *
     * @param Collector $dimensions
     */
    public function __construct(Collector $dimensions) {
        $this->width = $dimensions->getWidth();
        $this->height = $dimensions->getHeight();
    }
}