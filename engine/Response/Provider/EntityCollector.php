<?php

namespace InstaSave\Response\Provider;

use InstaSave\Enumeration\Entity;
use InstaSave\Response\Contract\Response;
use InstaSave\Exception\ResponseException;
use InstaSave\Response\Provider\ResponseProvider;

class EntityCollector extends ResponseProvider implements Response
{
    /**
     * Contains RAW response that comes from Footman.
     *
     * @var object
     */
    private $response;

    /**
     * Type of the Response Comes from Footman we will use it to detect Entity of the Response.
     *
     * @var Entity
     */
    public $type;

    /**
     * Constructor of Entity Collector.
     *
     * @param string $response
     */
    public function __construct($response) {
        $this->response = $response;

        $this->parse();
    }

    /**
     * Parse object that comes from Instagram Response to InstaSave Entity Classes.
     * We use this method to detect Type and find Response Entity.
     */
    public function parse() {
        $this->entity = $this->findEntity();
        $this->type = $this->predictType();
    }

    /**
     * Find the Entity of the Response.
     *
     * @return object | ResponseException
     */
    private function findEntity() {
        if (isset($this->response->entry_data->PostPage[0]->graphql->shortcode_media)) {
            return $this->response->entry_data->PostPage[0]->graphql->shortcode_media;
        }

        if (isset($this->response->entry_data->ProfilePage[0]->graphql->user)) {
            return $this->response->entry_data->ProfilePage[0]->graphql->user;
        }

        throw new ResponseException('No Result Found', 500);
    }

    /**
     * Find the type of the Response.
     *
     * @return Entity | ResponseException
     */
    private function predictType() {
        if (isset($this->entity->username)) {
            return Entity::user;
        }

        if (!isset($this->entity->__typename)) {
            throw new ResponseException('Undefined Instagram Entity', 500);
        }

        switch ($this->entity->__typename) {
            case 'GraphVideo':
                return $this->entity->product_type == Entity::igtv ? Entity::igtv : Entity::feed;
            case 'GraphImage':
                return Entity::feed;
            case 'GraphSidecar':
                return Entity::playlist;
            default:
                throw new ResponseException('Undefined Instagram Type', 500);
        }
    }
}