<?php

class FandomDataService {
	const API_BASE = 'http://fandom.wikia.com/wp-json/wp/v2/';

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes
	const MCACHE_TIME_LONG = 86400; // 24 hours

	const FANDOM_PER_PAGE = 10; // We ask for more than we need in case we need to filter any out
	const LIMIT = 5;

	private $options;
	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
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
	public function getPosts( $type, $ignoreTopic = false ) {
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$vertical = $wikiFactoryHub->getWikiVertical( $this->cityId )['short'];

		if ( $type === 'category' ) {
			$category = $this->setupCategories( $ignoreTopic );
		} else {
			$category = $this->setupVerticalCategory( $vertical );	
		}

		$memcKey = wfSharedMemcKey( __METHOD__, $type, $category, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() {
				return $this->apiRequest();
			}
		);

		return $data;
	}

	private function setupCategories( $ignoreTopic ) {
		// Hard coding in the SDCC category for now, eventually we will want to pass this in from JS
		$returnCategory = 4435;
		$this->options['categories'] = $returnCategory;

		$topicId = $this->getTopicCategoryId();

		if ( !empty( $topicId ) && empty( $ignoreTopic ) ) {
			$this->options['filter']['cat'] = $topicId;
			$returnCategory = $topicId;
		}

		return $returnCategory;
	}

	/**
	 * Get the category id from Fandom API
	 *
	 * @return integer
	 */
	public function getTopicCategoryId() {
		$tag = WikiFactory::getVarValueByName( 'wgRecirculationParselyCommunityTag', $this->cityId );

		if ( empty( $tag ) ) {
			return 0;
		}

		$memcKey = wfSharedMemcKey( __METHOD__, $tag, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME_LONG,
			function() use ( $tag ) {
				return $this->categoryApiRequest( $tag );
			}
		);

		return $data;
	}

	private function categoryApiRequest( $tag ) {
		$options = [
			'search' => $tag,
			'orderby' => 'count',
			'order' => 'desc',
			'per_page' => 1,
		];

		$url = $url = self::API_BASE . 'categories?' . http_build_query( $options );

		$data = ExternalHttp::get( $url );
		$data = json_decode( $data, true );

		if ( is_array( $data ) && count( $data ) > 0 ) {
			return $data[0]['id'];
		} else {
			return 0;
		}
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
		$url = self::API_BASE . 'hero_unit?' . http_build_query( $options );

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

		return $verticalMap[$vertical];
	}

	private function postHasImage( $post ) {
		return !empty( $post['_embedded']['wp:featuredmedia'][0]['media_details'] );
	}
}
