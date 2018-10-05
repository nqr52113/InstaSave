<?php

namespace InstaSave\Client;

use InstaSave\Client\Abstraction\ClientProvider;

class Client extends ClientProvider {
	protected function modifyOptions() {
		return [
	        'headers' => [
	        	'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
	        ]
	    ];
	}
}