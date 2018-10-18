<?php

namespace InstaSave\Client\Abstraction;

use Alshf\Footman;
use Alshf\Response;
use InstaSave\Exception\ClientException;
use InstaSave\URL\Abstraction\URLProvider;
use Symfony\Component\DomCrawler\Crawler;

abstract class ClientProvider
{
    /**
     * Footman Client that send All requests.
     *
     * @var Alshf\Footman
     */
    protected $client;

    /**
     * URL Object that Footman use it.
     *
     * @var URLProvider
     */
    protected $url;

    /**
     * Get to setup Footman Client.
     *
     * @var Illuminate\Support\Collection
     */
    protected $options;

    /**
     * Constructor of Client.
     *
     * @param URLProvider $url
     */
    public function __construct(URLProvider $url)
    {
        $this->url = $url;

        $this->options = $this->getOptions();

        $this->client = new Footman($this->options->toArray());
    }

    /**
     * Send Request to Instagram to get Basic JSON response.
     *
     * @return object | ClientException
     */
    public function send()
    {
        try {
            // Send Response to Instagram with GET request
            $response = $this->client->request(function ($request) {
                $request->request_type = 'GET';
                $request->request_url = $this->url->absoluteUrl;

                if ($this->requestNeedsCookieFile()) {
                    $request->cookies_name = 'InstaSave';
                }
            });
        } catch (\Exception $e) {
            // These Exception may comes from FootmanException that handles all
            // Connection, server, 4xx, 5xx Errors
            throw new ClientException('Client send Request Error.', 500, $e);
        }

        return $this->resolve($response);
    }

    /**
     * Customize Options for Footman Client.
     *
     * @return array
     */
    abstract protected function modifyOptions();

    /**
     * Get Options for Footman Client.
     *
     * @return Illuminate\Support\Collection
     */
    private function getOptions()
    {
        return collect([
            // Prevent Redirect bcuz on private feed it redirect to the user profile
            // So instead of no response we get profile type response
            'allow_redirects' => false,
            'cookies'         => [
                'share'                 => true,
                'type'                  => 'file',
                'store_session_cookies' => true,
            ],
        ])->merge($this->modifyOptions());
    }

    /**
     * Find JSON from Instagram Response and decode it to object.
     *
     * @param Response $response
     *
     * @return object
     */
    private function resolve(Response $response)
    {
        $crawler = new Crawler($response->getContents());

        $scripts = $crawler->filter('script')->each(function (Crawler $node, $i) {
            // JSON response Start with "window.sharedData ="
            if (preg_match('/^window\.\_sharedData\s*?\=\s*?(\{.+\})\;/i', $node->text(), $matches)) {
                return collect($matches)->pop();
            }
        });

        return json_decode(collect($scripts)->filter()->first());
    }

    /**
     * Check Footman Client needs cookies_name or not.
     *
     * @return bool
     */
    private function requestNeedsCookieFile()
    {
        $cookies = collect($this->options->get('cookies'));

        return $cookies->has('type') && strtolower($cookies->get('type')) === 'file';
    }
}
