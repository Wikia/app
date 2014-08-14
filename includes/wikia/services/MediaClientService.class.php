<?php

/**
 * This is a thin wrapper client code for Electrum service
 *
 */
class MediaClientService {

	/**
	 * @TODO: This should reflect the Electrum server
	 */
	const API_BASE_URL = 'http://localhost:5000';

	const API_VERSION = 'v1';
	const API_MEDIA_RESOURCE = 'media';
	const API_CONNECTION_TIMEOUT = 5;
	const DEFAULT_PAGE_SIZE = 10;

	/**
	 * @param array $params
	 *  'wiki' - string, required - wikia name //TODO: Remove
	 *  'wikiImagePath' - string, required - wikia image path
	 *  'wikiDB' - string, required - wikia database name
	 *  'mediaType' - string, required - video/image & possibly audio
	 *  'title' - string, optional - title of a file - providing this returns only the file
	 *  'categories' - array, optional - wikia video categories
	 *  'providers' - array, optional - wikia video providers
	 *  'page' - int, optional - offset page number - defaults to 0
	 *  'limit' - int, optional
	 *  'sort' - string, optional
	 * @return array of stdClass media objects
	 * @throws InvalidArgumentException
	 */
	public function getMedia( array $params ) {
		if ( !isset( $params['wiki'], $params['wikiImagePath'], $params['wikiDB'], $params['wiki'], $params['mediaType'] ) ) {
			throw new InvalidArgumentException( 'Missing required parameters wiki, wikiDB, mediaType' );
		}

		$filterParams = [
			'wiki' => $params['wiki'], // TODO: Remove
			'wikiImagePath' => $params['wikiImagePath'],
			'wikiDB' => $params['wikiDB'],
			'mediaType' => $params['mediaType'],
		];

		$filterParams['page'] = isset( $params['page'] ) ? ( int ) $params['page'] : 1;
		$filterParams['limit'] = isset( $params['limit'] ) ? ( int ) $params['limit'] : self::DEFAULT_PAGE_SIZE;

		if ( isset( $params['title'] ) ) {
			$filterParams['title'] = $params['title'];
		} else {
			if ( isset( $params['categories'] ) && is_array( $params['categories'] ) ) {
				$filterParams['category'] = implode( ',', $params['categories'] );
			}
			if ( isset( $params['providers'] ) && is_array( $params['providers'] ) ) {
				$filterParams['providers'] = implode( ',', $params['providers'] );
			}
			if ( isset( $params['sort'] ) ) {
				$filterParams['sort'] = $params['sort'];
			}
		}

		$qs = http_build_query( $filterParams );

		$url = self::API_BASE_URL . '/' . self::API_VERSION . '/' . self::API_MEDIA_RESOURCE;
		if ( $qs ) {
			$url .= '?' . $qs;
		}

		return json_decode( $this->getContent( $url ) );
	}

	/**
	 * Get the content of given URL
	 * @param string $url
	 * @return string
	 * @throws Exception
	 */
	protected function getContent( $url ) {
		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, self::API_CONNECTION_TIMEOUT );

		$content = curl_exec( $ch );
		curl_close( $ch );

		if ( !$content ) {
			throw new Exception( 'Failed to get data from media api. ' . curl_error( $ch ) );
		}

		return $content;
	}

}