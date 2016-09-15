<?php

/**
 * Class CrosslinkTagHelper
 */
class CrosslinkTagHelper extends WikiaModel {

	const CACHE_TTL = 86400;
	const FANDOM_API_URL = 'http://fandom.wikia.com/wp-json/wp/v2/posts';
	const VALID_HOST = 'fandom.wikia.com';

	/**
	 * Get data for the article
	 * @param string $slug - alphanumeric id
	 * @return array|false
	 */
	public function getArticleData( $slug ) {
		$cacheKey = $this->getMemcKey( $slug );
		$data = $this->wg->Memc->get( $cacheKey );
		if ( !is_array( $data ) ) {
			$params = [
				'_embed' => 1,
				'context' => 'embed',
				'per_page' => 1,
				'slug' => $slug,
			];

			$apiUrl = self::FANDOM_API_URL.'?' . http_build_query( $params );

			$method = 'GET';
			$options = [ 'noProxy' => true ];
			$response = Http::request( $method, $apiUrl, $options );
			if ( $response === false ) {
				return false;
			}

			$data = [];
			if ( !empty( $response ) ) {
				$response = json_decode( $response, true );
				if ( is_array( $response ) ) {
					$result = array_pop( $response );

					$data = [
						'title' => $result['title']['rendered'],
						'id' => $result['id'],
						'description' => trim( strip_tags( $result['excerpt']['rendered'] ) ),
						'url' => $result['link'],
						'imageUrl' => $this->getImageUrl( $result ),
					];
				}
			}

			$this->wg->Memc->set( $cacheKey, $data, self::CACHE_TTL );
		}

		return $data;
	}

	/**
	 * Get memcache key
	 * @param string $slug
	 * @return string
	 */
	public function getMemcKey( $slug ) {
		return wfSharedMemcKey( 'crosslinktag', 'fandom', md5( $slug ) );
	}

	/**
	 * Get image url for the article
	 * @param array $data - response from API
	 * @return string
	 */
	public function getImageUrl( $data ) {
		if ( !empty( $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'] ) ) {
			return $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium_large']['source_url'];
		}

		if ( !empty( $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'] ) ) {
			return $data['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'];
		}

		return '';
	}

}
