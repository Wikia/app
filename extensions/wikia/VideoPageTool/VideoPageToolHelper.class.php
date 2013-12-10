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
	 * Get list of sections
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
			// TODO: we no longer need the thumbnail html, only the url
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
				'videoKey'      => $title->getDBKey(),
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
			$data['imageKey'] = $imageTitle->getDBKey();

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
		for( $i = 1; $i <= self::$requiredRows[$section]; $i++ ) {
			$values[$i] = $className::getDefaultAssetData();
		}

		return $values;
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
				$data[] = $asset->getAssetData( $thumbOptions );
			}
		}

		return $data;
	}

}
