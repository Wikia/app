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
					[ 'id' => (int) $wikiId, 'wordmark' => $this->getWikiWordmarkImage( $wikiId ) ],
					$factoryData,
					$this->getFromService( $wikiId ),
					$this->getFromWAMService( $wikiId )
				);
			} else {
				$wikiInfo = [
					'id' => (int) $wikiId,
					'exists' => false
				];
			}
			$this->cacheWikiData( $wikiInfo );
		}
		//return empty result if wiki does not exist
		if ( isset( $wikiInfo[ 'exists' ] ) ) {
			return [];
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
		$imageName = $wikiInfo[ 'image' ];
		$crop = ( $width != null || $height != null );
		$width = ( $width !== null ) ? $width : static::DEFAULT_WIDTH;
		$height = ( $height !== null ) ? $height : static::DEFAULT_HEIGHT;
		$imgWidth = null;
		$imgHeight = null;
		$img = wfFindFile( $imageName );
		if ( $img instanceof WikiaLocalFile ) {
			//found on en-corporate wiki
			$imgWidth = $img->getWidth();
			$imgHeight = $img->getHeight();
			if ( $crop ) {
				//get original image if no cropping
				$imageServing = new ImageServing( null, $width, $height );
				$imgUrl = $imageServing->getUrl( $img, $width, $height );
			} else {
				$imgUrl = $img->getFullUrl();
			}
		} else {
			$f = $this->findGlobalFileImage( $imageName, $wikiInfo[ 'lang' ], $wikiInfo[ 'id' ] );
			if ( $f && $f->exists() ) {
				$imgWidth = $f->getWidth();
				$imgHeight = $f->getHeight();
				if ( $crop ) {
					$globalTitle = $f->getTitle();
					$imageService = new ImagesService();
					$response = $imageService->getImageSrc( $globalTitle->getCityId(), $globalTitle->getArticleID(), $width, $height );
					$imgUrl = $response[ 'src' ];
				} else {
					$imgUrl = $f->getUrl();
				}
			}
		}
		if ( isset( $imgUrl ) ) {
			return [ 'image' => $imgUrl, 'original_dimensions' => [ 'width' => $imgWidth, 'height' => $imgHeight ] ];
		}
		return [ 'image' => '' ];
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
			$imageName = UploadVisualizationImageFromFile::VISUALIZATION_MAIN_IMAGE_NAME;
			$f = GlobalFile::newFromText( $imageName, $wikiId );
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
			'wam_score' => floatval( $service->getCurrentWamScoreForWiki( $id ) )
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
		return [];
	}

	/**
	 * @param int $id WikiId
	 * @return array
	 */
	protected function getFromService( $id ) {
		$wikiStats = $this->getSiteStats( $id );
		$topUsers = $this->getTopEditors( $id, static::DEFAULT_TOP_EDITORS_NUMBER, true );
		$modelData = $this->getDetails( [ $id ] );

		//filter out flags
		$flags = [];
		if ( isset( $modelData[ $id ] ) ) {
			foreach ( $modelData[ $id ][ 'flags' ] as $name => $val ) {
				if ( $val == true && !in_array( $name, static::$flagsBlacklist ) ) {
					$flags[] = $name;
				}
			}
		}

		return [
			'stats' => [
				'edits' => (int) $wikiStats[ 'edits' ],
				'articles' => (int) $wikiStats[ 'articles' ],
				'pages' => (int) $wikiStats[ 'pages' ],
				'users' => (int) $wikiStats[ 'users' ],
				'activeUsers' => (int) $wikiStats[ 'activeUsers' ],
				'images' => (int) $wikiStats[ 'images' ],
				'videos' => (int) $this->getTotalVideos( $id ),
				'admins' => count( $this->getWikiAdminIds( $id ) )
			],
			'topUsers' => array_keys( $topUsers ),
			'headline' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'headline' ] : '',
			'lang' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'lang' ] : '',
			'flags' => $flags,
			'desc' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'desc' ] : '',
			'image' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'image' ] : '',
		];
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
			$this->keys[ $seed ] =  wfsharedMemcKey( static::MEMC_NAME.static::CACHE_VERSION.':'.$seed );
		}
		return $this->keys[ $seed ];
	}

	/**
	 * @param Array $wikiInfo Should contain at least 'id' field
	 * @param string $method Optional method name added to key string
	 */
	protected function cacheWikiData( $wikiInfo, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiInfo[ 'id' ].':'.$method : $wikiInfo[ 'id' ];
		$key = $this->getMemCacheKey( $seed );
		$wgMemc->set( $key, $wikiInfo, static::CACHE_1_DAY );
	}

	/**
	 * @param int $wikiId
	 * @param string $method Optional method name added to key string
	 * @return bool|Object
	 */
	protected function getFromCacheWiki( $wikiId, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiId.':'.$method : $wikiId;
		$key = $this->getMemCacheKey( $seed );
		return $wgMemc->get( $key );
	}

}
