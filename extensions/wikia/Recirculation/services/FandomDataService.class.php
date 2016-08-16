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

	public function __construct( $cityId, $type, $ignoreTopic = false ) {
		$this->cityId = $cityId;
		$this->options = [
			'_embed' => 1,
			'per_page' => self::FANDOM_PER_PAGE,
			'filter' => [],
			'context' => 'embed'
		];

		if ( $type === 'category' || $type === 'latest' ) {
			$this->setupCategories( $ignoreTopic );
		} else {
			$this->setupVerticalCategory( $vertical );
		}
	}

	/**
	 * Get posts for a specific type. Uses cache if available
	 *
	 * @return an array of posts
	 */
	public function getPosts( $type ) {
		$category = !empty( $this->options['categories'] ) ? $this->options['categories'] : 0;
		$topic = !empty( $this->options['filter']['cat'] ) ? $this->options['filter']['cat'] : 0;

		$memcKey = wfSharedMemcKey( __METHOD__, $type, $category, $topic, self::MCACHE_VER );

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
	private function apiRequest( $type ) {
		$options = [];

		$url = $this->buildUrl( $type, $this->options );
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
	private function buildUrl( $type, $options ) {
		switch ( $type ) {
			case 'latest':
				$date = (new \DateTime())->modify( '-24 hours' );
				$options['after'] = $date->format( DateTime::ATOM );
				$endpoint = 'posts';
				break;
			default:
				$options['filter']['orderby'] = 'menu_order';
				$endpoint = 'hero_unit';
				break;
		}

		return self::API_BASE . $endpoint . '?' . http_build_query( $options );
	}

	private function formatPosts( $data ) {
		$posts = [];

		foreach ($data as $key => $post) {
			if ($this->postHasImage( $post ) && count( $posts ) < self::LIMIT ) {
				$posts[] = new RecirculationContent( [
					'url' => empty($post['upstream_content_link']) ? $post['link'] : $post['upstream_content_link'],
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
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$vertical = $wikiFactoryHub->getWikiVertical( $this->cityId )['short'];

		$verticalMap = [
			'movies' => 5,
			'tv' => 6,
			'games' => 7,
		];

		if ( array_key_exists( $vertical, $verticalMap ) ) {
			$this->options['categories'] = $verticalMap[$vertical];
		}
	}

	private function setupCategories( $ignoreTopic ) {
		$topicId = $this->getTopicCategoryId();

		if ( !empty( $topicId ) && empty( $ignoreTopic ) ) {
			$this->options['filter']['cat'] = $topicId;
		}
	}

	/**
	 * Get the category id from Fandom API
	 *
	 * @return integer
	 */
	private function getTopicCategoryId() {
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

		$url = self::API_BASE . 'categories?' . http_build_query( $options );

		$data = ExternalHttp::get( $url );
		$data = json_decode( $data, true );

		if ( is_array( $data ) && count( $data ) > 0 ) {
			return $data[0]['id'];
		} else {
			return 0;
		}
	}

	private function postHasImage( $post ) {
		return !empty( $post['_embedded']['wp:featuredmedia'][0]['media_details'] );
	}
}
