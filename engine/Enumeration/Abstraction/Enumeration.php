<?php

namespace InstaSave\Enumeration\Abstraction;

use ReflectionClass;

abstract class Enumeration {
	static protected $constants;

	static public function valueOf($key) {
		if (!static::isValidKey($key)) {
			return null;
		}

		return self::getConstants()->get($key);
	}

	static public function keyOf($value) {
		if (!static::isValidValue($value)) {
			return null;
		}

		return self::getConstants()->search($value, true);
	}

	static public function isValidKey($key) {
		return self::getConstants()->has($key);
	}

	static public function isValidValue($value) {
		return self::getConstants()->containsStrict($value);
	}

	static private function getConstants() {
		if (!static::$constants) {
			$reflect = new ReflectionClass(static::class);

			return collect($reflect->getConstants());
		}

		return static::$constants;
	}
}
