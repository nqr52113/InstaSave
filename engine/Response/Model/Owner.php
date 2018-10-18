<?php

namespace InstaSave\Response\Model;

use InstaSave\Response\Provider\ResponseProvider as Collector;

class Owner
{
    /**
     * Owner Id.
     *
     * @var int
     */
    public $id;

    /**
     * Owner Username.
     *
     * @var string
     */
    public $username;

    /**
     * Owner Full name.
     *
     * @var string
     */
    public $fullname;

    /**
     * Owner Avator.
     *
     * @var string
     */
    public $avator;

    /**
     * Owner Constructor.
     *
     * @param Collector $owner
     */
    public function __construct(Collector $owner) {
        $this->id = $owner->getId();
        $this->username = $owner->getUsername();
        $this->fullname = $owner->getFullName();
        $this->avator = $owner->getProfilePicUrlHd() ?: $owner->getProfilePicUrl();
    }
}