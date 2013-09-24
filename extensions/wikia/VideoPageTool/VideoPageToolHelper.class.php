<?php

class VideoPageToolHelper extends WikiaModel {

	const DEFAULT_LANGUAGE = 'en';
	const DEFAULT_SECTION = 'featured';

	const THUMBNAIL_WIDTH = 180;
	const THUMBNAIL_HEIGHT = 100;

	const MAX_THUMBNAIL_WIDTH = 1024;
	const MAX_THUMBNAIL_HEIGHT = 461;

	public static $requiredRows = array(
		'featured' => 5,
		'category' => 4,
		'fan'      => 4,
	);

	/**
	 * get list of sections
	 * @return array $sections
	 */
	public function getSections() {
		$sections = array(
			'featured' => wfMessage( 'videopagetool-section-featured' )->plain(),
//			'category' => wfMessage( 'videopagetool-section-category' )->plain(),
//			'fan' => wfMessage( 'videopagetool-section-fan' )->plain(),
		);

		return $sections;
	}

	/**
	 * get list of languages
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
	 * get left menu items
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
	 * get url of the next munu item
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
	 * get video data
	 * @param string $videoTitle
	 * $param string $newThumbName
	 * @param string $displayTitle
	 * @param string $description
	 * @return array $video
	 */
	public function getVideoData( $videoTitle, $newThumbName = '', $displayTitle = '', $description = '' ) {
		wfProfileIn( __METHOD__ );

		$video = array();

		$title = Title::newFromText( $videoTitle, NS_FILE );
		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$videoTitle = $title->getText();
				if ( empty( $displayTitle ) ) {
					$displayTitle = $videoTitle;
				}

				// get thumbnail
				$thumb = $file->transform( array( 'width' => self::THUMBNAIL_WIDTH, 'height' => self::THUMBNAIL_HEIGHT ) );
				$videoThumb = $thumb->toHtml();
				$thumbUrl = $thumb->getUrl();

				$largeThumb = $file->transform( array( 'width' => self::MAX_THUMBNAIL_WIDTH, 'height' => self::MAX_THUMBNAIL_HEIGHT ) );
				$largeThumbUrl = $largeThumb->getUrl();

				// replace original thumbnail with the new one
				if ( !empty( $newThumbName ) ) {
					$imageData = $this->getImageData( $newThumbName );
					if ( !empty( $imageData ) ) {
						$videoThumb = str_replace( $thumbUrl, $imageData['thumbUrl'], $videoThumb );
						$largeThumbUrl = $imageData['largeThumbUrl'];
					}
				}

				// get description
				if ( empty( $description ) ) {
					$videoHandlerHelper = new VideoHandlerHelper();
					$description = $videoHandlerHelper->getVideoDescription( $file );
				}

				$video = array(
					'videoTitle'    => $videoTitle,
					'videoKey'      => $title->getDBKey(),
					'videoThumb'    => $videoThumb,
					'largeThumbUrl' => $largeThumbUrl,
					'newThumbName'  => $newThumbName,
					'displayTitle'  => $displayTitle,
					'description'   => $description,
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get image data
	 * @param string $imageTitle
	 * @return array $data [ array( 'thumbUrl' => $url, 'largeThumbUrl' => $url ) ]
	 */
	public function getImageData( $imageTitle ) {
		wfProfileIn( __METHOD__ );

		$data = array();

		$title = Title::newFromText( $imageTitle, NS_FILE );
		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() ) {
				$thumb = $file->transform( array( 'width' => self::THUMBNAIL_WIDTH, 'height' => self::THUMBNAIL_HEIGHT ) );
				$data['thumbUrl'] = $thumb->getUrl();

				$largeThumb = $file->transform( array( 'width' => self::MAX_THUMBNAIL_WIDTH, 'height' => self::MAX_THUMBNAIL_HEIGHT ) );
				$data['largeThumbUrl'] = $largeThumb->getUrl();
			}
		}

		wfProfileOut( __METHOD__ );

		return $data;
	}

	/**
	 * get default values by section
	 * @param string $section
	 * @return array $values
	 */
	public function getDefaultValuesBySection( $section ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$values = array();
		for( $i = 1; $i <= self::$requiredRows[$section]; $i++ ) {
			$values[$i] = $className::getDefaultAssetData();
		}

		return $values;
	}

	/**
	 * Validate form field
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
	 * Validate video
	 * @param string $videoTitle
	 * @param string $errMsg
	 * @return boolean
	 */
	public function validateVideoKey( $videoTitle, &$errMsg ) {
		$title = Title::newFromText( $videoTitle, NS_FILE );
		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				return true;
			}
		}

		$errMsg = wfMessage( 'videohandler-error-video-no-exist' )->plain();

		return false;
	}

	/**
	 * Validate description
	 * @param string $description
	 * @param string $errMsg
	 */
	public function validateDescriptiion( $description, &$errMsg ) {
		if ( strlen( $description ) > 200 ) {
			$errMsg = wfMessage( 'videopagetool-error-invalid-description' )->plain();
			return false;
		}

		return true;
	}

	/**
	 * Validate new thumbnail
	 * @param string $ThumbName
	 * @param string $errMsg
	 */
	public function validateNewThumbName( $ThumbName, &$errMsg ) {
		$title = Title::newFromText( $ThumbName, NS_FILE );
		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() ) {
				if ( $file->getWidth() == self::MAX_THUMBNAIL_WIDTH && $file->getHeight() == self::MAX_THUMBNAIL_HEIGHT ) {
					return true;
				}

				$errMsg = wfMessage( 'videopagetool-error-image-invalid-size' )->plain();
				return false;
			}
		}

		$errMsg = wfMessage( 'videopagetool-error-image-not-exist' )->plain();
		return false;
	}

}
