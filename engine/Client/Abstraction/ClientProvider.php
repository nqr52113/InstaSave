<?php
namespace InstaSave\Client\Abstraction;

use Alshf\Footman;
use Alshf\Response;
use InstaSave\URL\Abstraction\URLProvider;
use InstaSave\Exception\ClientException;
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

        return $this->resolve($response);
	}

	abstract protected function modifyOptions();

	private function getOptions() {
		return collect([
			// Prevent Redirect bcuz on private feed it redirect to the user profile
			// So instead of no response we get profile type response.
	        'allow_redirects' => false,
	        'cookies' => [
	            'share' => true,
	            'type' => 'file',
	            'store_session_cookies' => true
	        ]
		])->merge($this->modifyOptions());
	}

	private function resolve(Response $response) {
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