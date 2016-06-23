<?php

class FandomDataService {
	const API_BASE = 'http://fandom.wikia.com/wp-json/wp/v2/hero_unit';

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes

	const FANDOM_PER_PAGE = 10; // We ask for mor ethan we need in case we need to filter any out
	const LIMIT = 5;

	private $options;
	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
		// These options are specific to content for E3
		$this->options = [
			'_embed' => 1,
			'per_page' => self::FANDOM_PER_PAGE,
			'filter' => ['orderby' => 'menu_order'],
			'context' => 'embed'
		];
	}

	/**
	 * Get posts for a specific type. Uses cache if available
	 *
	 * @return an array of posts
	 */
	public function getPosts() {
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$vertical = $wikiFactoryHub->getWikiVertical( $this->cityId )['short'];

		$memcKey = wfSharedMemcKey( __METHOD__, $vertical, self::MCACHE_VER );

		$this->setupVerticalCategory( $vertical );
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
	 *
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
			if ($this->postHasImage( $post ) && count( $posts ) < self::LIMIT ) {
				$posts[] = new RecirculationContent( [
					'url' => $post['upstream_content_link'],
					'index' => $key,
					'thumbnail' => $post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'],
					'title' => html_entity_decode( $post['title']['rendered'] ),
					'publishDate' => $post['date'],
					'source' => 'fandom',
				] );
			}
		}

		return $posts;
	}

	private function setupVerticalCategory( $vertical ) {
		$verticalMap = [
			'movies' => 5,
			'tv' => 6,
			'games' => 7,
		];

		if ( array_key_exists( $vertical, $verticalMap ) ) {
			$this->options['categories'] = $verticalMap[$vertical];
		}
	}

	private function postHasImage( $post ) {
		return !empty( $post['_embedded']['wp:featuredmedia'][0]['media_details'] );
	}
}
