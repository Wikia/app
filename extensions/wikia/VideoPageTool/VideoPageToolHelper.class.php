<?php

/**
 * Class VideoPageToolHelper
 */
class VideoPageToolHelper extends WikiaModel {

	const DEFAULT_LANGUAGE = 'en';
	const DEFAULT_SECTION = 'featured';

	const THUMBNAIL_WIDTH = 291;
	const THUMBNAIL_HEIGHT = 131;

	const THUMBNAIL_CATEGORY_WIDTH = 297;
	const THUMBNAIL_CATEGORY_HEIGHT = 157;

	const MAX_THUMBNAIL_WIDTH = 1024;
	const MAX_THUMBNAIL_HEIGHT = 461;

	const MAX_VIDEOS_PER_CATEGORY = 24;

	const CACHE_TTL_CATEGORY_DATA = 3600;

	// minimum and maximum rows
	public static $requiredRows = array(
		'featured' => [5],
		'category' => [3, 5],
		'fan'      => [4],
	);

	/**
	 * Get list of sections
	 * @return array
	 */
	public function getSections() {
		$sections = array(
			VideoPageToolAssetFeatured::SECTION => wfMessage( 'videopagetool-section-featured' )->plain(),
			VideoPageToolAssetCategory::SECTION => wfMessage( 'videopagetool-section-category' )->plain(),
//			VideoPageToolAssetFan::SECTION => wfMessage( 'videopagetool-section-fan' )->plain(),
		);

		return $sections;
	}

	/**
	 * Get list of languages
	 * @return array
	 */
	public function getLanguages() {
		// default language codes
		$languageCodes = array( 'en' );

		$languages = array();
		foreach ( $languageCodes as $code ) {
			$languages[$code] = Language::getLanguageName( $code );
		}

		return $languages;
	}

	/**
	 * Get left menu items
	 * @param string $selected [featured/category/fan]
	 * @param array $sections
	 * @param string $language
	 * @param string $date [timestamp]
	 * @return array
	 */
	public function getLeftMenuItems( $selected, $sections, $language, $date ) {
		$query = array(
			'language' => $language,
			'date' => $date,
		);

		$leftMenuItems = array();
		foreach( $sections as $key => $value ) {
			$query['section'] = $key;
			$leftMenuItems[] = array(
				'title' => $value,
				'anchor' => $value,
				'href' => $this->wg->title->getLocalURL( $query ),
				'selected' => ($selected == $key),
			);
		}

		return $leftMenuItems;
	}

	/**
	 * Get url of the next munu item
	 * @param array $leftMenuItems
	 * @return string
	 */
	public function getNextMenuItemUrl( $leftMenuItems ) {
		$next = 0;
		foreach ( $leftMenuItems as $key => $item ) {
			if ( $item['selected'] ) {
				$next = $key;
				break;
			}
		}

		if ( $next < count( $leftMenuItems ) - 1 ) {
			$next++;
		}

		return $leftMenuItems[$next]['href'];
	}

	/**
	 * Get video data
	 * @param string $title
	 * @param string $altThumbTitle
	 * @param string $displayTitle
	 * @param string $description
	 * @param array $thumbOptions
	 * @return array
	 */
	public function getVideoData( $title, $altThumbTitle = '', $displayTitle = '', $description = '', $thumbOptions = array() ) {
		wfProfileIn( __METHOD__ );

		$video = array();

		/** @var Title $title A string $title will get converted to an object here */
		$file = WikiaFileHelper::getVideoFileFromTitle( $title );
		if ( !empty( $file ) ) {
			$videoTitle = $title->getText();
			if ( empty( $displayTitle ) ) {
				$displayTitle = $videoTitle;
			}

			// get thumbnail
			$thumb = $file->transform( array( 'width' => self::THUMBNAIL_WIDTH, 'height' => self::THUMBNAIL_HEIGHT ) );
			$videoThumb = $thumb->toHtml( $thumbOptions );
			$thumbUrl = $thumb->getUrl();

			$largeThumb = $file->transform( array( 'width' => self::MAX_THUMBNAIL_WIDTH, 'height' => self::MAX_THUMBNAIL_HEIGHT ) );
			$largeThumbUrl = $largeThumb->getUrl();

			// replace original thumbnail with the new one
			$altThumbName = '';
			$altThumbKey = '';
			if ( !empty( $altThumbTitle ) ) {
				$imageData = $this->getImageData( $altThumbTitle );
				if ( !empty( $imageData ) ) {
					$videoThumb = str_replace( $thumbUrl, $imageData['thumbUrl'], $videoThumb );
					$largeThumbUrl = $imageData['largeThumbUrl'];

					$altThumbName = $imageData['imageTitle'];
					$altThumbKey = $imageData['imageKey'];

					// TODO: Saipetch will fix this :)
					$thumbUrl = $imageData['thumbUrl'];
				}
			}

			// get description
			if ( empty( $description ) ) {
				$videoHandlerHelper = new VideoHandlerHelper();
				$description = $videoHandlerHelper->getVideoDescription( $file );
			}

			$video = array(
				'videoTitle'    => $videoTitle,
				'videoKey'      => $title->getDBkey(),
				'videoThumb'    => $videoThumb,
				'largeThumbUrl' => $largeThumbUrl,
				'altThumbName'  => $altThumbName,
				'altThumbKey'   => $altThumbKey,
				'displayTitle'  => $displayTitle,
				'description'   => $description,
				'thumbUrl'      => $thumbUrl,
			);
		}

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * Get a count of the videos in the given category
	 * @param Title $categoryTitle
	 * @return int
	 */
	public function getVideosByCategoryCount( Title $categoryTitle ) {
		wfProfileIn( __METHOD__ );

		$categoryKey = $categoryTitle->getDBkey();
		$memcKey = $this->getMemcKeyCountVideosByCategory( $categoryKey );
		$db = wfGetDB( DB_SLAVE );

		$count = (new WikiaSQL())->cache( self::CACHE_TTL_CATEGORY_DATA, $memcKey )
			->SELECT( 'count(distinct video_title)' )->AS_( 'count' )
			->FROM( 'page' )
				->JOIN( 'video_info' )->ON( 'page_title', 'video_title' )
				->JOIN( 'categorylinks' )->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $categoryKey )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE )
			->run( $db, function( $result ) {
				/** @var ResultWrapper $result */
				$row = $result->fetchObject();
				$count = empty($row) ? 0 : $row->count;
				return $count;
			});

		wfProfileOut( __METHOD__ );

		return $count;
	}

	/**
	 * Get videos tagged with the category given by parameter $categoryTitle (limit = 100)
	 * @param Title $categoryTitle
	 * @param array $thumbOptions
	 * @return array An array of video data where each array element has the structure:
	 *   [ title     => 'Video Title',
	 *     url       => 'http://url.to.video',
	 *     thumbnail => '<thumbnail_html_snippet>'
	 */
	public function getVideosByCategory( Title $categoryTitle, $thumbOptions = array() ) {
		wfProfileIn( __METHOD__ );

		$dbKey = $categoryTitle->getDBkey();
		$memcKey = $this->getMemcKeyVideosByCategory( $dbKey );
		$db = wfGetDB( DB_SLAVE );

		$thumbOptions['useTemplate'] = true;
		$thumbOptions['fluid'] = true;
		$thumbOptions['forceSize'] = 'small';

		$videos = (new WikiaSQL())->cache( self::CACHE_TTL_CATEGORY_DATA, $memcKey )

			->SELECT( 'page_id' )->FIELD( 'page_title' )
			->FROM( 'page' )
				->JOIN( 'video_info' )->ON( 'page_title', 'video_title' )
				->JOIN( 'categorylinks' )->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $dbKey )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE )
			->ORDER_BY( 'added_at ' )->DESC()
			->ORDER_BY( 'page_title' )
			->LIMIT( self::MAX_VIDEOS_PER_CATEGORY )

			->runLoop( $db, function ( &$videos, $row ) use ( $thumbOptions ) {
				/** @var Title $title Note: this is a string until the next line */
				$title = $row->page_title;

				// This method magically converts the string $title into an object
				$file = WikiaFileHelper::getVideoFileFromTitle( $title );

				if ( !empty( $file ) ) {
					$thumb = $file->transform( [
						'width'  => self::THUMBNAIL_CATEGORY_WIDTH,
						'height' => self::THUMBNAIL_CATEGORY_HEIGHT
					] );
					$videoThumb = $thumb->toHtml( $thumbOptions );
					$videos[] = [
						'title'     => $title->getText(),
						'url'       => $title->getFullURL(),
						'thumbnail' => $videoThumb,
					];
				}
			});

		wfProfileOut( __METHOD__ );

		return empty( $videos ) ? [] : $videos;
	}

	/**
 * Get memcache key for videos by category
 * @param $categoryName
 * @return string
 */
	public function getMemcKeyVideosByCategory( $categoryName ) {
		$categoryName = md5( $categoryName );
		return wfMemcKey( 'videopagetool', 'videosbycategory', $categoryName );
	}

	/**
	 * Get memcache key for count of videos by category
	 * @param $categoryName
	 * @return string
	 */
	public function getMemcKeyCountVideosByCategory( $categoryName ) {
		$categoryName = md5( $categoryName );
		return wfMemcKey( 'videopagetool', 'count-videos-by-category', $categoryName );
	}

	/**
	 * Clear cache for videos by category
	 * @param string $categoryName
	 */
	public function invalidateCacheVideosByCategory( $categoryName ) {
		$this->wg->Memc->delete( $this->getMemcKeyVideosByCategory( $categoryName ) );
		$this->wg->Memc->delete( $this->getMemcKeyCountVideosByCategory( $categoryName ) );
	}

	/**
	 * Replace thumbnail data (for video data only) - include videoThumb, largeThumbUrl, altThumbName, altThumbKey
	 * @param array $videoData
	 * @param string $newThumbnail
	 * @param array $thumbOptions
	 * @return array $videoData
	 */
	public function replaceThumbnail( $videoData, $newThumbnail, $thumbOptions = array() ) {
		if ( array_key_exists( 'videoKey', $videoData ) && !empty( $newThumbnail ) ) {
			$data = $this->getVideoData( $videoData['videoKey'], $newThumbnail, '', '', $thumbOptions );
			$videoData['videoThumb'] = $data['videoThumb'];
			$videoData['largeThumbUrl'] = $data['largeThumbUrl'];
			$videoData['altThumbName'] = $data['altThumbName'];
			$videoData['altThumbKey'] = $data['altThumbKey'];
		}

		return $videoData;
	}

	/**
	 * Get image data
	 * @param string $imageTitle
	 * @return array [ array( 'thumbUrl' => $url, 'largeThumbUrl' => $url ) ]
	 */
	public function getImageData( $imageTitle ) {
		wfProfileIn( __METHOD__ );

		$data = array();

		$file = WikiaFileHelper::getFileFromTitle( $imageTitle );
		if ( !empty( $file ) ) {
			$data['imageTitle'] = $imageTitle->getText();
			$data['imageKey'] = $imageTitle->getDBkey();

			$thumb = $file->transform( array( 'width' => self::THUMBNAIL_WIDTH, 'height' => self::THUMBNAIL_HEIGHT ) );
			$data['thumbUrl'] = $thumb->getUrl();

			$largeThumb = $file->transform( array( 'width' => self::MAX_THUMBNAIL_WIDTH, 'height' => self::MAX_THUMBNAIL_HEIGHT ) );
			$data['largeThumbUrl'] = $largeThumb->getUrl();
		}

		wfProfileOut( __METHOD__ );

		return $data;
	}

	/**
	 * Get default values by section
	 * @param string $section [featured/category/fan]
	 * @param integer $requiredRows
	 * @return array
	 */
	public function getDefaultValuesBySection( $section, $requiredRows = 0 ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$values = array();
		if ( empty( $requiredRows ) ) {
			$requiredRows = $this->getRequiredRowsMax( $section );
		}

		for ( $i = 1; $i <= $requiredRows; $i++ ) {
			$values[$i] = $className::getDefaultAssetData();
		}

		return $values;
	}

	/**
	 * Get required rows for this section
	 * Note: displayTitle field is used to check for number of rows in the form
	 * @param string $section [featured/category/fan]
	 * @param array $formValues
	 * @return integer
	 */
	public function getRequiredRows( $section, $formValues ) {
		$cnt = empty( $formValues['displayTitle']  ) ? 0 : count( $formValues['displayTitle'] );
		$min = $this->getRequiredRowsMin( $section );
		$max = $this->getRequiredRowsMax( $section );
		if ( $cnt <= $min ) {
			$requiredRows = $min;
		} else if ( $cnt < $max ) {
			$requiredRows = $cnt;
		} else {
			$requiredRows = $max;
		}

		return $requiredRows;
	}

	/**
	 * Get minimum required rows for this section
	 * @param string $section [featured/category/fan]
	 * @return integer
	 */
	public function getRequiredRowsMin( $section ) {
		return min( self::$requiredRows[$section] );
	}

	/**
	 * Get maximum required rows for this section
	 * @param string $section [featured/category/fan]
	 * @return integer
	 */
	public function getRequiredRowsMax( $section ) {
		return max( self::$requiredRows[$section] );
	}

	/**
	 * Validate form field (called from VideoPageToolAsset::formatFormData())
	 * @param string $formFieldName
	 * @param string $value
	 * @param string $errMsg
	 * @return boolean
	 */
	public function validateFormField( $formFieldName, $value, &$errMsg ) {
		if ( empty( $value ) ) {
			$errMsg = wfMessage( 'videohandler-error-missing-parameter', $formFieldName )->plain();
			return false;
		}

		$methodName = 'validate'.ucfirst( $formFieldName );
		if ( method_exists( $this, $methodName ) ) {
			return $this->$methodName( $value, $errMsg );
		}

		return true;
	}

	/**
	 * Validate video (called from validateFormField())
	 * @param string $videoTitle
	 * @param string $errMsg
	 * @return boolean
	 */
	public function validateVideoKey( $videoTitle, &$errMsg ) {
		$file = WikiaFileHelper::getVideoFileFromTitle( $videoTitle );
		if ( !empty( $file ) ) {
			return true;
		}

		$errMsg = wfMessage( 'videohandler-error-video-no-exist' )->plain();

		return false;
	}

	/**
	 * Validate description (called from validateFormField())
	 * @param string $description
	 * @param string $errMsg
	 * @return bool
	 */
	public function validateDescription( $description, &$errMsg ) {
		if ( strlen( $description ) > 200 ) {
			$errMsg = wfMessage( 'videopagetool-error-invalid-description' )->plain();
			return false;
		}

		return true;
	}

	/**
	 * Validate category (called from validateFormField())
	 * @param string $categoryName
	 * @param string $errMsg
	 * @return boolean
	 */
	public function validateCategoryName( $categoryName, &$errMsg ) {
		$title = Title::newFromText( $categoryName, NS_CATEGORY );
		if ( $title instanceof Title && count( $this->getVideosByCategory( $title ) ) > 0 ) {
			return true;
		}

		$errMsg = wfMessage( 'videopagetool-error-empty-category' )->plain();

		return false;
	}

	/**
	 * Validate alternative thumbnail (called from validateFormField())
	 * @param string $imageTitle
	 * @param string $errMsg
	 * @return bool
	 */
	public function validateAltThumbKey( $imageTitle, &$errMsg ) {
		$file = WikiaFileHelper::getFileFromTitle( $imageTitle );
		if ( !empty( $file ) ) {
			if ( $file->getWidth() == self::MAX_THUMBNAIL_WIDTH && $file->getHeight() == self::MAX_THUMBNAIL_HEIGHT ) {
				return true;
			}

			$errMsg = wfMessage( 'videopagetool-error-image-invalid-size' )->plain();
			return false;
		}

		$errMsg = wfMessage( 'videopagetool-error-image-not-exist' )->plain();
		return false;
	}

	/**
	 * Render assets by section (used in VideoHomePageController)
	 * @param VideoPageToolProgram $program
	 * @param string $section [featured/category/fan]
	 * @param array $thumbOptions An optional array of thumbnail options to override the defaults for the given asset.
	 * @return array
	 */
	public function renderAssetsBySection( $program, $section, $thumbOptions = array() ) {
		$data = array();
		if ( $program instanceof VideoPageToolProgram ) {
			$assets = $program->getAssetsBySection( $section );
			foreach ( $assets as $asset ) {
				/** @var VideoPageToolAsset $asset */
				$data[] = $asset->getAssetData( $thumbOptions );
			}
		}

		return $data;
	}

}
