<?php

namespace InstaSave\Response\Provider;

use InstaSave\Exception\ResponseException;

abstract class ResponseProvider
{
    /**
     * After Response Comes from Instagram as a string it will parse from JSON to a Object,
     * This property contains that object.
     *
     * @var object
     */
    public $entity;

    /**
     * When try to get from provider it will get it from its own entity object.
     *
     * @param string $key
     *
     * @return mix
     */
    public function get($key)
    {
        return collect(explode('.', $key))->reduce(function ($carry, $property) {
            $property = snake_case($property);

            // Check if we want to acces array index with #.
            // like edges#1 find the edges property which it is an array then get the first element of it
            preg_match('/^(.+)?\#(.+)$/', $property, $matches);

            if ($matches && isset($carry->{$matches[1]}[$matches[2]])) {
                return $carry->{$matches[1]}[$matches[2]];
            }

            if (isset($carry->{$property})) {
                return $carry->{$property};
            }
        }, $this->entity);
    }

    /**
     * When call method on Collector it will get from entity object.
     *
     * @param string $method
     * @param string $arguments
     *
     * @return mix
     */
    public function __call($method, $arguments)
    {
        if (!preg_match('/^get(.+)$/', $method, $matches)) {
            throw new ResponseException('Method doesn\'t exist!', 500);
        }

        return $this->get(snake_case($matches[1]));
    }
}
