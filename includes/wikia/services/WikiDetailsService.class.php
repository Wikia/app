<?php

class WikiDetailsService extends WikiService {

	const CACHE_1_DAY = 86400;//1 day
	const MEMC_NAME = 'SharedWikiApiData:';
	const DEFAULT_TOP_EDITORS_NUMBER = 10;
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = null;
	const DEFAULT_SNIPPET_LENGTH = null;
	const CACHE_VERSION = 3;
	const WORDMARK_URL_SETTING = 'wordmark-image-url';
	private static $flagsBlacklist = array( 'blocked', 'promoted' );

	protected $keys;
	protected $themeSettings;

	/**
	 * Returns detailed information about wiki
	 * @param $wikiId
	 * @param int $width Wikia image width
	 * @param int $height Wikia image height
	 * @param int $snippet Snippet length in number of words
	 * @return array Wikia detailed data
	 */
	public function getWikiDetails( $wikiId, $width = null, $height = null, $snippet = null ) {
		if ( ( $cached = $this->getFromCacheWiki( $wikiId ) ) !== false ) {
			$wikiInfo = $cached;
		} else {
			//get data providers
			$factoryData = $this->getFromWikiFactory( $wikiId, $exists );
			if ( $exists ) {
				$wikiInfo = array_merge(
					[ 'id' => (int)$wikiId, 'wordmark' => $this->getWikiWordmarkImage( $wikiId ) ],
					$factoryData,
					$this->getFromService( $wikiId ),
					$this->getFromWAMService( $wikiId ),
					$this->getFromCommunityData( $wikiId )
				);
			} else {
				$wikiInfo = [
					'id' => (int)$wikiId,
					'exists' => false
				];
			}
			$this->cacheWikiData( $wikiInfo );
		}
		//return empty result if wiki does not exist
		if ( isset( $wikiInfo[ 'exists' ] ) ) {
			return [ ];
		}
		//post process thumbnails
		$wikiInfo = array_merge(
			$wikiInfo,
			$this->getImageData( $wikiInfo, $width, $height )
		);
		//set snippet
		if ( isset( $wikiInfo[ 'desc' ] ) ) {
			$length = ( $snippet !== null ) ? $snippet : static::DEFAULT_SNIPPET_LENGTH;
			$wikiInfo[ 'desc' ] = $this->getSnippet( $wikiInfo[ 'desc' ], $length );
		} else {
			$wikiInfo[ 'desc' ] = '';
		}
		return $wikiInfo;
	}

	/**
	 * @param array $wikiInfo
	 * @param int $width Image width
	 * @param int $height Image height
	 * @return array
	 */
	protected function getImageData( $wikiInfo, $width = null, $height = null ) {
		// check community data image first
		if ( isset( $wikiInfo[ 'image' ][ 'community' ] ) && $wikiInfo[ 'image' ][ 'community' ] ) {
			return $this->getImage(
				GlobalFile::newFromText( $wikiInfo[ 'image' ][ 'title' ], $wikiInfo[ 'id' ] ), $width, $height );
		}
		$imageName = $wikiInfo[ 'image' ];
		$img = wfFindFile( $imageName );
		if ( $img ) {
			return $this->getImage( $img, $width, $height );
		}
		$f = $this->findGlobalFileImage( $imageName, $wikiInfo[ 'lang' ], $wikiInfo[ 'id' ] );
		return $this->getImage( $f, $width, $height );
	}

	/**
	 * @param GlobalFile|File $file
	 * @param $width
	 * @param $height
	 * @return array
	 */
	protected function getImage( $file, $width, $height ) {
		if ( !$file || !$file->exists() ) {
			// nothing to do here
			return [ 'image' => '' ];
		}
		$crop = ( $width != null || $height != null );
		$width = ( $width !== null ) ? $width : static::DEFAULT_WIDTH;
		$height = ( $height !== null ) ? $height : static::DEFAULT_HEIGHT;
		return [
			'image' => $crop ? ( new ImageServing( null, $width, $height ) )->getUrl( $file, $width, $height )
				: ( $file instanceof WikiaLocalFile ? $file->getFullUrl() : $file->getUrl() ),
			'original_dimensions' => [
				'width' => $file->getWidth(),
				'height' => $file->getHeight()
			]
		];
	}

	/**
	 * @param string $imageName
	 * @param string $lang
	 * @param int $wikiId
	 * @return GlobalFile|null
	 */
	protected function findGlobalFileImage( $imageName, $lang, $wikiId ) {
		//try to find image on lang specific corporate wiki
		$f = null;
		$visualizationModel = new CityVisualization();
		$cityList = $visualizationModel->getVisualizationWikisData();

		if ( isset( $cityList[ $lang ] ) ) {
			$f = GlobalFile::newFromText( $imageName, $cityList[ $lang ][ 'wikiId' ] );
		} else {
			//if image wasn't found, try to find it on wiki itself
			$promoImage = ( new PromoImage( PromoImage::MAIN ) )->setCityId( $wikiId );
			$f = $promoImage->getOriginFile();
		}

		return $f;
	}

	/**
	 * @param int $id WikiId
	 * @return string
	 */
	protected function getWikiWordmarkImage( $id ) {
		$settings = WikiFactory::getVarByName( ThemeSettings::WikiFactorySettings, $id );
		$values = unserialize( $settings->cv_value );
		return ( isset( $values[ self::WORDMARK_URL_SETTING ] ) ) ? $values[ self::WORDMARK_URL_SETTING ] : '';
	}

	/**
	 * @param int $id WikiId
	 * @return array
	 */
	protected function getFromWAMService( $id ) {
		$service = new WAMService();
		return [
			'wam_score' => $service->getCurrentWamScoreForWiki( $id )
		];
	}

	/**
	 * @param int $id WikiId
	 * @param boolean $exists States if Wikia with given id exists
	 * @return array
	 */
	protected function getFromWikiFactory( $id, &$exists = null ) {
		$exists = false;
		$wikiObj = WikiFactory::getWikiByID( $id );
		if ( $wikiObj ) {
			$exists = true;
			return [
				'title' => $wikiObj->city_title,
				'url' => $wikiObj->city_url,
			];
		}
		return [ ];
	}

	/**
	 * @param int $id WikiId
	 * @return array
	 */
	protected function getFromService( $id ) {
		global $wgEnableDiscussions;

		$wikiStats = $this->getSiteStats( $id );
		$topUsers = $this->getTopEditors( $id, static::DEFAULT_TOP_EDITORS_NUMBER, true );
		$modelData = $this->getDetails( [ $id ] );

		//filter out flags
		$flags = [ ];
		if ( isset( $modelData[ $id ] ) ) {
			foreach ( $modelData[ $id ][ 'flags' ] as $name => $val ) {
				if ( $val == true && !in_array( $name, static::$flagsBlacklist ) ) {
					$flags[] = $name;
				}
			}
		}

		$wikiDetails = [
			'stats' => [
				'edits' => (int)$wikiStats[ 'edits' ],
				'articles' => (int)$wikiStats[ 'articles' ],
				'pages' => (int)$wikiStats[ 'pages' ],
				'users' => (int)$wikiStats[ 'users' ],
				'activeUsers' => (int)$wikiStats[ 'activeUsers' ],
				'images' => (int)$wikiStats[ 'images' ],
				'videos' => (int)$this->getTotalVideos( $id ),
				'admins' => count( $this->getWikiAdminIds( $id ) )
			],
			'topUsers' => array_keys( $topUsers ),
			'headline' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'headline' ] : '',
			'title' => isset( $modelData [ $id ] ) ? $modelData[ $id ][ 'title' ] : '',
			'name' => isset( $modelData [ $id ] ) ? $modelData[ $id ][ 'name' ] : '',
			'domain' => isset( $modelData [ $id ] ) ? $modelData[ $id ][ 'domain' ] : '',
			'hub' => isset( $modelData [ $id ] ) ? $modelData[ $id ][ 'hub' ] : '',
			'lang' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'lang' ] : '',
			'topic' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'topic' ] : '',
			'flags' => $flags,
			'desc' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'desc' ] : '',
			'image' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'image' ] : '',
		];

		if ( $wgEnableDiscussions ) {
			$wikiDetails[ 'stats' ][ 'discussions' ] = (int)$this->getDiscussionStats( $id );
		}

		return $wikiDetails;
	}

	protected function getFromCommunityData( $wikiId ) {
		$result = [ ];
		if ( !empty( $wikiId ) ) {
			$provider = new CommunityDataService( $wikiId );
			$desc = $provider->getCommunityDescription();
			if ( !empty( $desc ) ) {
				$result = [ 'desc' => $desc ];
			}
			$image = GlobalTitle::newFromId( $provider->getCommunityImageId(), $wikiId );
			if ( $image && $image->exists() ) {
				$result[ 'image' ] = [ 'community' => true, 'title' => $image->getText() ];
			}
		}
		return $result;
	}

	/**
	 * @param string $text
	 * @param int $length By default snippet won't be stripped
	 * @return string
	 */
	protected function getSnippet( $text, $length = null ) {
		if ( $length !== null ) {
			$length = max( $length, 0 );
			return implode( ' ', array_slice( explode( ' ', $text ), 0, $length ) );
		}
		return $text;
	}

	/**
	 * @param string $seed
	 * @return mixed
	 */
	protected function getMemCacheKey( $seed ) {
		if ( !isset( $this->keys[ $seed ] ) ) {
			$this->keys[ $seed ] = wfsharedMemcKey( static::MEMC_NAME . static::CACHE_VERSION . ':' . $seed );
		}
		return $this->keys[ $seed ];
	}

	/**
	 * @param Array $wikiInfo Should contain at least 'id' field
	 * @param string $method Optional method name added to key string
	 */
	protected function cacheWikiData( $wikiInfo, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiInfo[ 'id' ] . ':' . $method : $wikiInfo[ 'id' ];
		$key = $this->getMemCacheKey( $seed );
		$wgMemc->set( $key, $wikiInfo, static::CACHE_1_DAY );
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	private function getDiscussionStats( $id ) {
		global $wgConsulServiceTag, $wgConsulUrl;

		$consulUrl = ( new Wikia\Service\Gateway\ConsulUrlProvider( $wgConsulUrl, $wgConsulServiceTag ))->getUrl( 'discussion' );
		$response = Http::get( "http://$consulUrl/$id/forums/$id?limit=1", 'default', array( 'noProxy' => true ));
		if ( $response !== false ) {
			$decodedResponse = json_decode( $response, true );
			if ( isset( $decodedResponse[ 'threadCount' ] ) && json_last_error() === JSON_ERROR_NONE ) {
				return $decodedResponse[ 'threadCount' ];
			}
		}
		return null;
	}

	/**
	 * @param int $wikiId
	 * @param string $method Optional method name added to key string
	 * @return bool|Object
	 */
	protected function getFromCacheWiki( $wikiId, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiId . ':' . $method : $wikiId;
		$key = $this->getMemCacheKey( $seed );
		return $wgMemc->get( $key );
	}

}
