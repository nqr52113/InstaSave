<?php
namespace InstaSave\Abstraction;

use Alshf\Footman;
use Alshf\Response;
use InstaSave\Abstraction\URLProvider;
use InstaSave\Exceptions\ClientException;
use Symfony\Component\DomCrawler\Crawler;

abstract class ClientProvider {
	protected $client;

	protected $url;

	protected $options;

	public function __construct(URLProvider $url) {
		$this->url = $url;

		$this->options = $this->getOptions();

		$this->client = new Footman($this->options->toArray());
	}

	public function send() {
		$provider = $this;

		try {
			$response = $this->client->request(function ($request) use ($provider) {
	            $request->request_type = 'GET';
	            $request->request_url = $this->url->absoluteUrl;

	            if ($provider->requestNeedsCookieFile()) {
	            	$request->cookies_name = 'InstaSave';
	            }
	        });
		} catch (\Exception $e) {
			throw new ClientException('Client send Request Error.', 500, $e);
		}

        return $this->parse($response);
	}

	abstract protected function modifyOptions();

	private function getOptions() {
		return collect([
	        'allow_redirects' => true,
	        'cookies' => [
	            'share' => true,
	            'type' => 'file',
	            'store_session_cookies' => true
	        ]
		])->merge($this->modifyOptions());
	}

	private function parse(Response $response) {
		$crawler = new Crawler($response->getContents());

		$scripts = $crawler->filter('script')->each(function (Crawler $node, $i) {
			if (preg_match('/^window\.\_sharedData\s*?\=\s*?(\{.+\})\;/i', $node->text(), $matches)) {
				return collect($matches)->pop();
			}
		});

		return json_decode(collect($scripts)->filter()->first());
	}

	private function requestNeedsCookieFile() {
		$cookies = collect($this->options->get('cookies'));

		return $cookies->has('type') && strtolower($cookies->get('type')) === 'file';
	}
}