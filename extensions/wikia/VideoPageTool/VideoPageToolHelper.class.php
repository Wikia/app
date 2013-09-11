<?php

class VideoPageToolHelper extends WikiaModel {

	const DEFAULT_LANGUAGE = 'en';
	const DEFAULT_SECTION = 'featured';

	const THUMBNAIL_WIDTH = 180;
	const THUMBNAIL_HEIGHT = 100;

	/**
	 * get list of sections
	 * @return array $sections
	 */
	public function getSections() {
		$sections = array(
			'featured' => wfMessage( 'videopagetool-section-featured' )->plain(),
			'trending' => wfMessage( 'videopagetool-section-trending' )->plain(),
			'fan' => wfMessage( 'videopagetool-section-fan' )->plain(),
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
	 * @param string $selected [featured/trending/fan]
	 * @param string $language
	 * @param string $date [timestamp]
	 * @return array $leftMenuItems
	 */
	public function getLeftMenuItems( $selected, $language, $date ) {
		$sections = $this->getSections();
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
	 * get video data
	 * @param string $videoTitle
	 * @param string $displayTitle
	 * @param string $description
	 * @return array $video
	 */
	public function getVideoData( $videoTitle, $displayTitle = '', $description = '' ) {
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

				// get description
				if ( empty( $description ) ) {
					$videoHandlerHelper = new VideoHandlerHelper();
					$description = $videoHandlerHelper->getVideoDescription( $file );
				}

				$video = array(
					'videoTitle' => $videoTitle,
					'videoKey' => $title->getDBKey(),
					'displayTitle' => $displayTitle,
					'videoThumb' => $videoThumb,
					'description' => $description,
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get default values by section
	 * @param string $section
	 * @return array $values
	 */
	public function getDefaultValuesBySection( $section ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$values = array();
		for( $i = 1; $i <= $className::$REQUIRED_ROWS; $i++ ) {
			$values[$i] = $className::getDefaultAssetData();
		}

		return $values;
	}

}
