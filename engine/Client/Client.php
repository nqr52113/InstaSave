<?php

namespace InstaSave\Client;

use InstaSave\Client\Abstraction\ClientProvider;

class Client extends ClientProvider
{
    /**
     * Customize Options for Footman Client.
     *
     * @return array
     */
    protected function modifyOptions()
    {
        return [
            'headers' => [
                // Footman Client User Agent
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
            ],
        ];
    }
}
