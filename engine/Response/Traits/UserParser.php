<?php

namespace InstaSave\Response\Traits;

trait UserParser
{
    /**
     * Entity Type.
     *
     * @var Entity
     */
    public $type;

    /**
     * User Biography.
     *
     * @var string
     */
    public $biography;

    /**
     * Number of users who follow this user.
     *
     * @var int
     */
    public $followedBy;

    /**
     * Number of users this user follow.
     *
     * @var int
     */
    public $follow;

    /**
     * Verifed user on instagram?
     *
     * @var boolean
     */
    public $isVerified;

    /**
     * Find User of Instagram.
     *
     * @return InstaSave\Response\Abstraction\ResponseDecorator
     */
    private function user() {
        $this->type = $this->provider->type;
        $this->biography = $this->provider->getBiography();
        $this->followedBy = $this->provider->get('edgeFollowedBy.count');
        $this->follow = $this->provider->get('edgeFollow.count');
        $this->isVerified = $this->provider->getIsVerified();

        return $this;
    }
}