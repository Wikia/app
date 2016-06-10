<?php

class FandomDataService {
	const API_BASE = 'http://fandom.wikia.com/wp-json/wp/v2/hero_unit';

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes

	private $options;

	public function __construct() {
		// These options are specific to content for E3
		$this->options = [
			'_embed' => 1,
			'categories' => 4434,
			'per_page' => 5,
			'filter' => ['orderby' => 'menu_order'],
			'context' => 'embed'
		];
	}

	/**
	 * Get posts for a specific type. Uses cache if available
	 * @param string $type
	 * @return an array of posts
	 */
	public function getPosts( $type ) {
		$memcKey = wfSharedMemcKey( __METHOD__, $type, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() {
				return $this->apiRequest();
			}
		);

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest() {
		$options = [];

		$url = $this->buildUrl( $this->options );
		$data = ExternalHttp::get( $url );

		$data = json_decode( $data, true );

		if ( is_array( $data ) ) {
			return $this->formatPosts( $data );
		} else {
			return [];
		}
	}

	/**
	 * Build a complete url to the parsely API
	 * @param array $options
	 * @return string
	 */
	private function buildUrl( $options ) {
		$url = self::API_BASE . '?' . http_build_query( $options );

		return $url;
	}

	private function formatPosts( $data ) {
		$posts = [];

		foreach ($data as $key => $post) {
			$posts[] = new RecirculationContent( [
				'url' => $post['upstream_content_link'],
				'index' => $key,
				'thumbnail' => $post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'],
				'title' => $post['title']['rendered'],
				'publishDate' => $post['date'],
				'source' => 'fandom',
			] );
		}

		return $posts;
	}
}
