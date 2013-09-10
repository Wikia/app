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
			'section' => $selected,
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
	 * get list of programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @param string $endDate [yyyy-mm-dd]
	 * @return array $programs [array( date => status ); date = yyyy-mm-dd; status = 0 (not published)/ 1 (published)]
	 */
	public function getPrograms( $language, $startDate, $endDate ) {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyPrograms( $language, $startDate );
		$programs = $this->wg->Memc->get( $memKey );
		if ( empty( $programs )) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_program' ),
				array( "date_format( publish_date, '%Y-%m-%d' ) publish_date, is_published" ),
				array(
					'language' => $language,
					"publish_date >= '$startDate'",
					"publish_date < '$endDate'",
				),
				__METHOD__,
				array( 'ORDER BY' => 'publish_date' )
			);

			$programs = array();
			while ( $row = $db->fetchObject($result) ) {
				$programs[$row->publish_date] = $row->is_published;
			}

			$this->wg->Memc->set( $memKey, $programs, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $programs;
	}

	/**
	 * get memcache key for programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @return string
	 */
	public function getMemKeyPrograms( $language, $startDate ) {
		return wfMemcKey( 'videopagetool', 'programs', $language, $startDate );
	}

}
