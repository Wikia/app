<?php

/**
 * Class CrosslinkTagHelper
 */
class CrosslinkTagHelper extends WikiaModel {

	const CACHE_TTL = 3600;
	const FANDOM_API_URL = 'http://fandom.wikia.com/wp-json/wp/v2/';
	const VALID_HOST = 'fandom.wikia.com';

	protected $endpoints = [
		'articles' => 'posts',
		'videos' => 'video',
	];

	/**
	 * Show the crosslink unit only on Article pages and Main pages
	 * @return boolean
	 */
	public function canShowUnit() {
		if ( !$this->app->checkSkin( 'oasis' ) ) {
			return false;
		}

		$title = $this->wg->Title;
		if ( $title instanceof Title && $title->getNamespace() == NS_MAIN ) {
			return true;
		}

		return false;
	}

	/**
	 * Get data for the article by slug
	 * @param string $slug - alphanumeric id
	 * @param string $pageType - page type
	 * @return array|false
	 */
	public function getArticleDataBySlug( $slug, $pageType = 'articles' ) {
		$cacheKey = $this->getMemcKey( $slug );
		$data = $this->wg->Memc->get( $cacheKey );
		if ( !is_array( $data ) ) {
			$params = [
				'_embed' => 1,
				'slug' => $slug,
			];

			if ( array_key_exists( $pageType, $this->endpoints ) ) {
				$endpoint = $this->endpoints[$pageType];
			} else {
				$endpoint = $this->endpoints['articles'];
			}

			$apiUrl = self::FANDOM_API_URL . $endpoint.'?' . http_build_query( $params );
			$method = 'GET';
			$options = [ 'noProxy' => true ];

			$response = Http::request( $method, $apiUrl, $options );
			if ( $response === false ) {
				return false;
			}

			$data = [];
			$response = json_decode( $response, true );
			if ( !empty( $response[0]['id'] ) ) {
				$result = array_pop( $response );

				$data = [
					'title' => html_entity_decode( $result['title']['rendered'] ),
					'id' => $result['id'],
					'description' => $this->getArticleDescription( $result ),
					'url' => $result['link'],
					'imageUrl' => $this->getArticleImageUrl( $result ),
				];
			}

			$this->wg->Memc->set( $cacheKey, $data, self::CACHE_TTL );
		}

		return $data;
	}

	/**
	 * Get memcache key
	 * @param string $name - unique name (slug)
	 * @return string
	 */
	public function getMemcKey( $name ) {
		return wfSharedMemcKey( 'crosslinktag', 'fandom', md5( $name ) );
	}

	/**
	 * Get description for the article
	 * @param array $data - response from API
	 * @return string
	 */
	protected function getArticleDescription( $data ) {
		if ( !empty( $data['excerpt']['rendered'] ) ) {
			$description = $data['excerpt']['rendered'];
		} else if ( !empty( $data['content']['rendered'] ) ) {
			$description = $data['content']['rendered'];
		} else {
			$description = '';
		}

		return html_entity_decode( trim( strip_tags( $description ) ) );
	}

	/**
	 * Get image url for the article
	 * @param array $data - response from API
	 * @return string
	 */
	protected function getArticleImageUrl( $data ) {
		if ( !empty( $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'] ) ) {
			return $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'];
		}

		if ( !empty( $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'] ) ) {
			return $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'];
		}

		return '';
	}

}
