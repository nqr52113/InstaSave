<?php

namespace InstaSave\Enumeration;

use InstaSave\Enumeration\Abstraction\Enumeration;

abstract class Entity extends Enumeration {
	const playlist = 'playlist';
	const user = 'user';
	const igtv = 'igtv';
	const feed = 'feed';
}
