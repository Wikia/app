<?php

class VideoPageToolHelper extends WikiaModel {

	const DEFAULT_LANGUAGE = 'en';
	const DEFAULT_SECTION = 'featured';

	const THUMBNAIL_WIDTH = 180;
	const THUMBNAIL_HEIGHT = 100;

	const THUMBNAIL_CATEGORY_WIDTH = 263;
	const THUMBNAIL_CATEGORY_HEIGHT = 148;

	const MAX_THUMBNAIL_WIDTH = 1024;
	const MAX_THUMBNAIL_HEIGHT = 461;

	const CACHE_TTL_CATEGORY_DATA = 300;

	public static $requiredRows = array(
		'featured' => 5,
		'category' => [3, 5],
		'fan'      => 4,
	);

	/**
	 * Get list of sections
	 * @return array $sections
	 */
	public function getSections() {
		$sections = array(
			'featured' => wfMessage( 'videopagetool-section-featured' )->plain(),
			'category' => wfMessage( 'videopagetool-section-category' )->plain(),
//			'fan' => wfMessage( 'videopagetool-section-fan' )->plain(),
		);

		return $sections;
	}

	/**
	 * Get list of languages
	 * @return array $languages
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
	 * @return array $leftMenuItems
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
	 * @return array $video
	 */
	public function getVideoData( $title, $altThumbTitle = '', $displayTitle = '', $description = '', $thumbOptions = array() ) {
		wfProfileIn( __METHOD__ );

		$video = array();

		$file = WikiaFileHelper::getVideoFileFromTitle( $title );
		if ( !empty( $file ) ) {
			$videoTitle = $title->getText();
			if ( empty( $displayTitle ) ) {
				$displayTitle = $videoTitle;
			}

			// get thumbnail
			$thumb = $file->transform( array( 'width' => self::THUMBNAIL_WIDTH, 'height' => self::THUMBNAIL_HEIGHT ) );
			$thumbOptions = array(
				'hidePlayButton' => false
			);
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
	 * Get videos tagged with the category given by parameter $categoryTitle
	 * @param string $categoryTitle A category name, or a title object for a category
	 * @param int $limit The maximum number of videos to return
	 * @return array $videos An array of video data where each array element has the structure:
	 *   [ title => 'Video Title',
	 *     url   => 'http://url.to.video',
	 *     thumb => '<thumbnail_html_snippet>'
	 */
	public function getVideosByCategory( $categoryTitle, $limit = 100 ) {
		wfProfileIn( __METHOD__ );

		// Accept either a category object or a category name
		$dbKey = is_object( $categoryTitle ) ? $categoryTitle->getDBkey() : $categoryTitle;

		$memcKey = $this->getMemcKeyVideosByCategory( $dbKey );
		$videos = $this->wg->memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
			$db = wfGetDB( DB_SLAVE );
			$result = $db->select(
				array( 'page', 'video_info', 'categorylinks' ),
				array( 'page_id', 'page_title' ),
				array(
					'cl_to' => $dbKey,
					'page_namespace' => NS_FILE,
				),
				__METHOD__,
				array(
					'ORDER BY' => 'added_at DESC, page_title',
					'LIMIT' => $limit,
				),
				array(
					'video_info' => array( 'LEFT JOIN', 'page_title = video_title' ),
					'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' )
				)
			);

			$videos = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$title = $row->page_title;
				$file = WikiaFileHelper::getVideoFileFromTitle( $title );
				if ( !empty( $file ) ) {
					$thumb = $file->transform( array( 'width' => self::THUMBNAIL_CATEGORY_WIDTH, 'height' => self::THUMBNAIL_CATEGORY_HEIGHT ) );
					$videoThumb = $thumb->toHtml( [ 'useTemplate' => true ] );
					$videos[] = array(
						'title' => $title->getText(),
						'url'   => $title->getFullURL(),
						'thumb' => $videoThumb,
					);
				}
			}

			$this->wg->memc->set( $memcKey, $videos, self::CACHE_TTL_CATEGORY_DATA );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
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
	 * Clear cache for videos by category
	 */
	public function invalidateCacheVideosByCategory( $categoryName ) {
		$this->wg->Memc->delete( $this->getMemcKeyVideosByCategory( $categoryName ) );
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
	 * @return array $data [ array( 'thumbUrl' => $url, 'largeThumbUrl' => $url ) ]
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
	 * @param string $section
	 * @return array $values
	 */
	public function getDefaultValuesBySection( $section ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$values = array();
		$requiredRows = $this->getRequiredRows( $section );
		for ( $i = 1; $i <= $requiredRows; $i++ ) {
			$values[$i] = $className::getDefaultAssetData();
		}

		return $values;
	}

	/**
	 * Get required rows
	 * Note: displayTitle field is used to check for number of rows in the form
	 * @param string $section
	 * @param array $fieldValues
	 * @return integer $requiredRows
	 */
	public function getRequiredRows( $section, $fieldValues = array() ) {
		if ( is_array( self::$requiredRows[$section] ) ) {
			$cnt = is_array( $fieldValues ) ? count( $fieldValues ) : 0;
			$min = min( self::$requiredRows[$section] );
			$max = max( self::$requiredRows[$section] );
			if ( $cnt <= $min ) {
				$requiredRows = $min;
			} else if ( $cnt < $max ) {
				$requiredRows = $cnt;
			} else {
				$requiredRows = $max;
			}
		} else {
			$requiredRows = self::$requiredRows[$section];
		}

		return $requiredRows;
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
	public function validateDescriptiion( $description, &$errMsg ) {
		if ( strlen( $description ) > 200 ) {
			$errMsg = wfMessage( 'videopagetool-error-invalid-description' )->plain();
			return false;
		}

		return true;
	}

	/**
	 * Validate category
	 * @param string $categoryName
	 * @param string $errMsg
	 * @return boolean
	 */
	public function validateCategoryName( $categoryName, &$errMsg ) {
		$title = Title::newFromText( $categoryName, NS_CATEGORY );
		if ( $title instanceof Title ) {
			return true;
		}

		$errMsg = wfMessage( 'videopagetool-unknown-category' )->plain();

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
	 * @return type
	 */
	public function renderAssetsBySection( $program, $section ) {
		$data = array();
		if ( $program instanceof VideoPageToolProgram ) {
			$thumbOptions = array( 'noLightbox' => true );
			$assets = $program->getAssetsBySection( $section );
			foreach ( $assets as $asset ) {
				/** @var VideoPageToolAsset $asset */
				$data[] = $asset->getAssetData( $thumbOptions );
			}
		}

		return $data;
	}

}
