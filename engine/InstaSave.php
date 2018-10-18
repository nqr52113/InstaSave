<?php

namespace InstaSave;

use InstaSave\Client\Abstraction\ClientProvider;
use InstaSave\Client\Client;
use InstaSave\Response\Provider\EntityCollector;
use InstaSave\URL\Abstraction\URLProvider;

class InstaSave
{
    /**
     * URL that we want to get the Response.
     *
     * @var URLProvider
     */
    private $url;

    /**
     * The Footman Client which send request to Instagram.
     *
     * @var Alshf\Footman
     */
    private $client;

    /**
     * Instasave Constructor.
     *
     * @param URLProvider         $url
     * @param ClientProvider|null $client
     */
    public function __construct(URLProvider $url, ClientProvider $client = null)
    {
        $this->url = $url;

        $this->client = $client ?: new Client($this->url);
    }

    /**
     * Send Request and Fetch the result as a response string.
     *
     * @return InstaSave\Response\Contract\Response
     */
    public function fetch()
    {
        // Create an EntityCollector from response String and find the JSON and then Parse it as
        // a Object and store it in Entity Collector in "entity" property.
        // It also find the Respnse type [User, Playlist, Feed, IGTV]
        $provider = new EntityCollector($this->client->send());

        // Create a class from the provider (EntityCollector) and make a Response Entity Object from it
        $class = 'InstaSave\\Response\\Entity\\'.ucfirst($provider->type);

        // Now parse Provider (EntityCollector) "entity" property to Response Entity Object
        return (new $class($provider))->parse();
    }
}
