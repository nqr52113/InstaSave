<?php

namespace InstaSave\Response\Traits;

use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Provider\ModelCollector;

trait EntityParser
{
    /**
     * Entity ID.
     *
     * @var int
     */
    public $id;

    /**
     * Entity Type.
     *
     * @var Entity
     */
    public $type;

    /**
     * Entity Shortcode.
     *
     * @var string
     */
    public $shortcode;

    /**
     * Entity Dimension.
     *
     * @var Dimension
     */
    public $dimensions;

    /**
     * Number of Entity comments.
     *
     * @var int
     */
    public $comments;

    /**
     * Number of Entity likes.
     *
     * @var int
     */
    public $likes;

    /**
     * Posted at timestamp.
     *
     * @var int
     */
    public $postedAt;

    /**
     * Entity Description.
     *
     * @var string
     */
    public $description;

    /**
     * Fill All common property on Entity.
     *
     * @return InstaSave\Response\Abstraction\ResponseDecorator
     */
    private function entity()
    {
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
