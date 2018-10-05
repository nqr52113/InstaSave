<?php

namespace InstaSave\Response;

use InstaSave\Enumeration\Entity;
use InstaSave\Response\Contract\Response;
use InstaSave\Exception\ResponseException;

class ResponseProvider implements Response {
	private $response;
	public $entity;
	public $type;

	public function __construct($response) {
		$this->response = $response;

		$this->make();
	}

	public function make() {
		$this->entity = $this->getEntity();
		$this->type = $this->getType();
	}

	private function getEntity() {
		if (isset($this->response->entry_data->PostPage[0]->graphql->shortcode_media)) {
			return $this->response->entry_data->PostPage[0]->graphql->shortcode_media;
		}

		if (isset($this->response->entry_data->ProfilePage[0]->graphql->user)) {
			return $this->response->entry_data->ProfilePage[0]->graphql->user;
		}

		throw new ResponseException('No Result Found', 500);
	}

	private function getType() {
		if (isset($this->entity->username)) {
			return Entity::user;
		}

		if (!isset($this->entity->__typename)) {
			throw new ResponseException('Undefined Instagram Post Type', 500);
		}

		switch ($this->entity->__typename) {
			case 'GraphVideo':
				return $this->entity->product_type == Entity::igtv ? Entity::igtv : Entity::feed;
			case 'GraphImage':
				return Entity::feed;
			case 'GraphSidecar':
				return Entity::playlist;
			default:
				throw new ResponseException('Undefined Instagram Post Type', 500);
		}
	}
}