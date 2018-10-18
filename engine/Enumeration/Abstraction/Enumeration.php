<?php

namespace InstaSave\Enumeration\Abstraction;

use ReflectionClass;

abstract class Enumeration
{
    /**
     * Contains all Constants of Enumeration.
     *
     * @var Illuminate\Support\Collection
     */
    static protected $constants;

    /**
     * Get value of the Enum.
     *
     * @param  string $key
     *
     * @return string
     */
    static public function valueOf($key) {
        if (!static::isValidKey($key)) {
            return null;
        }

        return self::getConstants()->get($key);
    }

    /**
     * Get Enum name of the Value.
     *
     * @param  string $value
     *
     * @return string
     */
    static public function keyOf($value) {
        if (!static::isValidValue($value)) {
            return null;
        }

        return self::getConstants()->search($value, true);
    }

    /**
     * Check this Enum exist.
     *
     * @param  string  $key
     *
     * @return boolean
     */
    static public function isValidKey($key) {
        return self::getConstants()->has($key);
    }

    /**
     * Check this value exist in Enums.
     * 
     * @param  string  $value
     *
     * @return boolean
     */
    static public function isValidValue($value) {
        return self::getConstants()->containsStrict($value);
    }

    /**
     * Find all Enums and their value and store them as a Collection.
     *
     * @return Illuminate\Support\Collection
     */
    static private function getConstants() {
        if (!static::$constants) {
            // Get all Constants with Reflection
            $reflect = new ReflectionClass(static::class);

            return collect($reflect->getConstants());
        }

        return static::$constants;
    }
}
