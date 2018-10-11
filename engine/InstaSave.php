<?php

namespace InstaSave;

use InstaSave\Client\Client;
use InstaSave\URL\Abstraction\URLProvider;
use InstaSave\Client\Abstraction\ClientProvider;
use InstaSave\Response\Provider\EntityCollector;

class InstaSave {
	
	private $url;

	private $client;

	public function __construct(URLProvider $url, ClientProvider $client = null) {
		$this->url = $url;

		$this->client = $client ?: new Client($this->url);
	}

	public function fetch() {
		$provider = new EntityCollector($this->client->send());

		$class = 'InstaSave\\Response\\Entity\\' . ucfirst($provider->type);

		return (new $class($provider))->parse();
	}
}
