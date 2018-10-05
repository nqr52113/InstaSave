<?php

namespace InstaSave;

use InstaSave\Client\Client;
use InstaSave\Response\ResponseProvider;
use InstaSave\URL\Abstraction\URLProvider;
use InstaSave\Client\Abstraction\ClientProvider;

class InstaSave {
	
	private $url;

	private $client;

	public function __construct(URLProvider $url, ClientProvider $client = null) {
		$this->url = $url;

		$this->client = $client ?: new Client($this->url);
	}

	public function fetch() {
		$result = $this->client->send();

		$provider = new ResponseProvider($result);

		$class = 'InstaSave\\Response\\Entity\\' . ucfirst($provider->type);
		
		$response = new $class($provider);

		$response->make();

		return $response;
	}
}
