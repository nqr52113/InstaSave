<?php

namespace InstaSave\Response\Provider;

use InstaSave\Exception\ResponseException;

abstract class ResponseProvider {
	public $entity;

	public function get($key) {
		return collect(explode('.', $key))->reduce(function ($carry, $property) {
			$property = snake_case($property);

			preg_match('/^(.+)?\#(.+)$/', $property, $matches);

			if ($matches && isset($carry->{$matches[1]}[$matches[2]])) {
				return $carry->{$matches[1]}[$matches[2]];
			}

			if (isset($carry->{$property})) {
				return $carry->{$property};
			}

			return null;
		}, $this->entity);
	}

	public function __call($method, $arguments) {
		if (!preg_match('/^get(.+)$/', $method, $matches)) {
			throw new ResponseException('Method doesn\'t exist!', 500);
		}

		return $this->get(snake_case($matches[1]));
	}
}