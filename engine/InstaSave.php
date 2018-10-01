<?php

namespace InstaSave;

use InstaSave\Providers\Client;
use InstaSave\Abstraction\URLProvider;

class InstaSave {
	
	private $url;

	private $client;

	public function __construct(URLProvider $url, ClientProvider $client = null) {
		$this->url = $url;

		$this->client = $client ?: new Client($this->url);
	}

	public function fetch() {
		$response = $this->client->send();

        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->__typename);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->dimensions);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->display_url);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->video_url);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->video_view_count);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->is_video);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->edge_media_to_comment->count);
        var_dump($response->entry_data->PostPage[0]->graphql->shortcode_media->edge_media_preview_like->count);
	}
}