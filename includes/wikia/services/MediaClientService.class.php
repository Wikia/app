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
	const CITY_VARIABLES_POOL_NAME = 'wgUploadDirectory';

	/**
	 * Get a set of media file data via the Electrum media service
	 *
	 * @param array $params
	 *  'mediaType' - string, required - video/image & possibly audio
	 *  'wikiImagePath' - string, optional - wikia image path - defaults to current wikia's
	 *  'wikiDB' - string, optional - wikia database name - defaults to current wikia's
	 *  'title' - string, optional - title of a file - providing this returns only the file
	 *  'categories' - array, optional - wikia video categories
	 *  'providers' - array, optional - wikia video providers
	 *  'page' - int, optional - offset page number - defaults to 0
	 *  'limit' - int, optional
	 *  'sort' - string, optional - values: 'recent', 'trend', 'popular'
	 * @return array of stdClass media objects
	 * @throws InvalidArgumentException
	 */
	public function getMedia( array $params ) {
		if ( !isset( $params['mediaType'] ) ) {
			throw new InvalidArgumentException( 'mediaType is missing. Must be video or image' );
		}

		if ( !isset( $params['wikiImagePath'], $params['wikiDB'] ) ) {
			$dbName = F::app()->wg->DBname;
			$params['wikiDB'] = $dbName;
			$params['wikiImagePath'] = $this->getImagePath( $dbName );
		}

		$filterParams = [
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
		$content = Http::request( 'GET', $url, ['noProxy' => true] );
		if ( !$content ) {
			throw new Exception( 'Failed to get data from media api.' );
		}

		return $content;
	}

	/**
	 * Get the image path for given wikia DB name
	 * @param string $dbName
	 * @return string
	 * @throws Exception
	 */
	protected function getImagePath( $dbName ) {
		$uploadDirectory = F::app()->wg->DBname;

		if ( !empty( $uploadDirectory ) ) {
			$wikiImagePath = $uploadDirectory;
		} else {
			// Go to the db to get it!

			global $wgExternalSharedDB;
			// Get the image URL path for this wikia
			$db = wfGetDB( DB_SLAVE, [ ], $wgExternalSharedDB );
			$wikiImagePath = ( new WikiaSQL() )
				->SELECT( 'cv_value' )
				->FROM( 'city_variables' )
				->JOIN( 'city_list' )->ON( 'city_id', 'cv_city_id' )
				->JOIN( 'city_variables_pool' )
				->WHERE( 'cv_name' )->EQUAL_TO( self::CITY_VARIABLES_POOL_NAME )
				->AND_( 'city_dbname' )->EQUAL_TO( $dbName )
				->run( $db, function ( $result ) {
						$row = $result->fetchObject();
						return empty( $row ) ? '' : unserialize( $row->cv_value );
					}
				);

			if ( empty( $wikiImagePath ) ) {
				throw new Exception( 'Image path was not found!' );
			}
		}

		// E.g. /images/t/thelastofus/images => thelastofus/images
		$parts = explode( '/', $wikiImagePath );
		return $parts[3] . '/' . $parts[4];
	}
}