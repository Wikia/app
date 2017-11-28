<?php

class ScreenplayFeedIngester extends RemoteAssetFeedIngester {

	const TIMEOUT = 60;

	protected static $API_WRAPPER = 'ScreenplayApiWrapper';
	protected static $PROVIDER = 'screenplay';
	protected static $FEED_URL = 'https://$2:$3@www.totaleclips.com/api/v1/assets?vendorid=$1&group_by_title=1&date_added=$4&date_added_end=$5&bitrateID=$6';

	protected static $FORMAT_ID_THUMBNAIL = 9;
	protected static $FORMAT_ID_VIDEO = 20;

	// list of bit rate ids in priority for videos (higer number, higher priority)
	protected static $BITRATE_IDS_THUMBNAIL = [
		ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID => 1,
		ScreenplayApiWrapper::LARGE_JPEG_BITRATE_ID  => 2,
	];

	// list of bit rate ids in priority for videos (higer number, higher priority)
	protected static $BITRATE_IDS_VIDEO = [
		ScreenplayApiWrapper::STANDARD_43_BITRATE_ID  => 4,
		ScreenplayApiWrapper::STANDARD_BITRATE_ID     => 5,
		ScreenplayApiWrapper::STANDARD2_43_BITRATE_ID => 2,
		ScreenplayApiWrapper::STANDARD2_BITRATE_ID    => 3,
		ScreenplayApiWrapper::HIGHDEF_BITRATE_ID      => 1,
	];

	// map bit rate id to resolution
	protected static $VIDEO_RESOLUTION = [
		ScreenplayApiWrapper::STANDARD_43_BITRATE_ID  => '480x360',
		ScreenplayApiWrapper::STANDARD_BITRATE_ID     => '480x270',
		ScreenplayApiWrapper::STANDARD2_43_BITRATE_ID => '640x480',
		ScreenplayApiWrapper::STANDARD2_BITRATE_ID    => '640x360',
		ScreenplayApiWrapper::HIGHDEF_BITRATE_ID      => '1280x720',
	];

	protected static $TRAILER_TYPE = [
		0  => 'Not Set',
		1  => 'Home Video',
		2  => 'Theatrical',
		20 => 'Open-ended',
		21 => 'Video Game',
		22 => 'TV Trailer',
		23 => 'Music Video',
	];

	protected static $TRAILER_VERSION = [
		0  => 'Not Set',
		1  => 'Trailer',
		2  => 'Extra (Clip)',
	];

	protected static $RATING_TRAILER = [
		0   => 'Not Set',
		29  => 'Redband',
		30  => 'Greenband',
		34  => 'NR',
	];

	protected static $RATING_MPAA = [
		0  => 'Not Set',
		1  => 'G',
		2  => 'PG',
		3  => 'PG-13',
		4  => 'R',
		5  => 'NC-17',
	];

	// Skip Movie Trailers (trailer type = Home Video, Theatrical, Open-ended )
	private static $EXCLUDE_TRAILER_TYPE = [ 1, 2, 20 ];

	/**
	 * Download feed from API
	 * @param string $startDate
	 * @param string $endDate
	 * @param integer|null $ageGate
	 * @return string $content
	 */
	public function downloadFeed( $startDate, $endDate, $ageGate = null ) {
		wfProfileIn( __METHOD__ );

		$url = $this->initFeedUrl( $startDate, $endDate, $ageGate );

		print( "Connecting to $url...\n" );

		$content = $this->getUrlContent( $url, [ 'timeout' => self::TIMEOUT ] );
		if ( $content === false  ) {
			$this->logger->videoErrors( "ERROR: problem downloading content.\n" );
			wfProfileOut( __METHOD__ );
			return 0;
		}

		wfProfileOut( __METHOD__ );

		return $content;
	}

	/**
	 * Get feed url
	 * @param string $startDate
	 * @param string $endDate
	 * @param integer|null $ageGate
	 * @return string $url
	 */
	private function initFeedUrl( $startDate, $endDate, $ageGate ) {
		global $wgScreenplayApiConfig;

		$url = str_replace( '$1', $wgScreenplayApiConfig['customerId'], static::$FEED_URL );
		$url = str_replace( '$2', $wgScreenplayApiConfig['username'], $url );
		$url = str_replace( '$3', $wgScreenplayApiConfig['password'], $url );
		$url = str_replace( '$4', $startDate, $url );
		$url = str_replace( '$5', $endDate, $url );

		$bitrates = array_keys( self::$BITRATE_IDS_THUMBNAIL + self::$BITRATE_IDS_VIDEO );
		$url = str_replace( '$6', implode( ',', $bitrates ), $url );

		if ( isset( $ageGate ) ) {
			$url .= '&ageGate='.$ageGate;
		}

		return $url;
	}

	/**
	 * Import videos
	 * @param string $content
	 * @param array $params
	 * @return integer $articlesCreated
	 */
	public function import( $content = '', array $params = [] ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;
		$ageGateValues = [0, 1];
		$startDate = empty( $params['startDate'] ) ? '' : $params['startDate'];
		$endDate = empty( $params['endDate'] ) ? '' : $params['endDate'];

		foreach ( $ageGateValues as $value ) {
			$content = $this->downloadFeed( $startDate, $endDate, $value );
			if ( !empty( $content ) ) {
				$params['ageGate'] = $value;
				$articlesCreated += $this->ingestVideos( $content, $params );
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Ingest videos
	 * @param string $content
	 * @param array $params
	 * @return integer $articlesCreated
	 */
	public function ingestVideos( $content = '', $params = [] ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;

		$titles = json_decode( $content, true );
		if ( empty( $titles ) ) {
			$titles = [];
		}

		$numTitles = count( $titles );
		print( "Found $numTitles titles...\n" );

		foreach ( $titles as $title ) {
			if ( empty( $title['Assets'] ) ) {
				$this->logger->videoSkipped();
				continue;
			}

			$clipData = [
				'titleName'       => $title['Name'],
				'year'            => $title['Year'],
				'name'            => $title['Name'],
				'videoId'         => null,
				'jpegBitrateCode' => ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID,
				'stdBitrateCode'  => 0,
				'streamUrl'       => '',
				'streamHdUrl'     => '',
				'hd'              => 0,
				'resolution'      => '',
			];

			$addlCategories = [];
			if ( !empty( $params['keyphrasesCategories'] ) ) {
				foreach ( $params['keyphrasesCategories'] as $keyphrase => $categories ) {
					if ( $this->isKeyphraseInString( $clipData['titleName'], $keyphrase ) ) {
						$addlCategories = array_merge( $addlCategories, $categories );
					}
				}
			}

			// get data for all assets in the title
			$videos = [];
			foreach ( $title['Assets'] as $clip ) {
				if ( empty( $clip['EClipId'] ) ) {
					$this->logger->videoSkipped();
					continue;
				}

				// Skip Movie Trailers (trailer type = Home Video, Theatrical, Open-ended )
				if ( in_array( $clip['TrailerTypeId'], self::$EXCLUDE_TRAILER_TYPE ) && $clip['TrailerVersion'] == 1 ) {
					$this->logger->videoSkipped();
					continue;
				}

				$clip['AgeGate'] = $params['ageGate'];
				if ( array_key_exists( $clip['EClipId'], $videos ) ) {
					$videos[$clip['EClipId']] = $this->getClipData( $clip, $videos[$clip['EClipId']] );
				} else {
					$this->logger->printAndSetResultSummary( 'found' );
					$clipData['addlCategories'] = $addlCategories;
					$videos[$clip['EClipId']] = $this->getClipData( $clip, $clipData );
				}
			}

			// create videos
			foreach ( $videos as $video ) {
				// set hd and resolution
				if ( !empty( $video['stdBitrateCode'] ) ) {
					$video['hd'] = 0;
					$video['resolution'] = self::$VIDEO_RESOLUTION[$video['stdBitrateCode']];
				} else if ( !empty( $video['streamHdUrl'] ) ) {
					$video['hd'] = 1;
					$video['resolution'] = self::$VIDEO_RESOLUTION[ScreenplayApiWrapper::HIGHDEF_BITRATE_ID];
				}

				// get addlCategories
				$addlCategories = $video['addlCategories'];
				unset( $video['addlCategories'] );

				$articlesCreated += $this->createVideo( $video, $addlCategories );
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Get clip data
	 * @param array $clip - data from API
	 * @param array $clipData
	 * @return array $clipData
	 */
	protected function getClipData( $clip, $clipData ) {
		wfProfileIn( __METHOD__ );

		// set thumbnail encode
		if ( $clip['FormatId'] == self::$FORMAT_ID_THUMBNAIL
			&& self::$BITRATE_IDS_THUMBNAIL[$clip['BitrateId']] >= self::$BITRATE_IDS_THUMBNAIL[$clipData['jpegBitrateCode']] ) {
			$clipData['thumbnail'] = $clip['Url'];
			$clipData['jpegBitrateCode'] = $clip['BitrateId'];
		}

		// set video encode
		if ( $clip['FormatId'] == self::$FORMAT_ID_VIDEO ) {
			if ( $clip['BitrateId'] == ScreenplayApiWrapper::HIGHDEF_BITRATE_ID ) {
				$clipData['streamHdUrl'] = $clip['Url'];
			} else if ( empty( $clipData['stdBitrateCode'] )
				|| self::$BITRATE_IDS_VIDEO[$clip['BitrateId']] > self::$BITRATE_IDS_VIDEO[$clipData['stdBitrateCode']] ) {
				$clipData['stdBitrateCode'] = $clip['BitrateId'];
				$clipData['streamUrl'] = $clip['Url'];
			}
		}

		if ( !empty( $clipData['videoId'] ) ) {
			wfProfileOut( __METHOD__ );
			return $clipData;
		}

		$clipData['videoId'] = $clip['EClipId'];
		$clipData['published'] = strtotime( $clip['DateAdded'] );
		$clipData['duration'] = $clip['Runtime'];

		// set description
		$clipData['description'] = str_replace( [ '[', ']' ], '', str_replace( '][', ', ', $clip['Description'] ) );

		// set category
		$trailerType = empty( self::$TRAILER_TYPE[$clip['TrailerTypeId']] ) ? '' : self::$TRAILER_TYPE[$clip['TrailerTypeId']];
		$clipData['category'] = $this->getCategory( $trailerType );

		// set series
		$clipData['series'] = ( $trailerType == 'TV Trailer' ) ? $clipData['name'] : '';

		// set type
		$trailerVersion = empty( self::$TRAILER_VERSION[$clip['TrailerVersion']] ) ? '' : self::$TRAILER_VERSION[$clip['TrailerVersion']];
		$clipData['type'] = $this->getType( $trailerVersion );

		// set additional category
		if ( empty( $clipData['addlCategories'] ) ) {
			if ( strtolower( $clipData['type'] ) == 'trailer'
				&& ( strtolower( $clipData['category'] ) != 'games' && stripos( $clipData['titleName'], '(VG)' ) === false ) ) {
				$clipData['addlCategories'][] = 'Movie Trailers';
			}
		}

		// check Trailer Rating first. if not found, check MPAA Rating
		$rating = empty( self::$RATING_TRAILER[$clip['RatingId']] ) ? '' : self::$RATING_TRAILER[$clip['RatingId']];
		$trailerRating = $this->getIndustryRating( $rating );
		if ( !empty( $trailerRating ) && $trailerRating != 'NR' ) {
			$clipData['industryRating'] = $trailerRating;
		} else if ( !empty( self::$RATING_MPAA[$clip['RatingId']] ) ) {
			$clipData['industryRating'] = $this->getIndustryRating( self::$RATING_MPAA[$clip['RatingId']] );
		} else {
			$clipData['industryRating'] = '';
		}

		// set age required if ageGate is set
		if  ( empty( $clip['AgeGate'] ) ) {
			$clipData['ageGate'] = 0;
			$clipData['ageRequired'] = 0;
		} else {
			$clipData['ageGate'] = 1;
			$clipData['ageRequired'] = $this->getAgeRequired( $clipData['industryRating'] );
			// set age required to 17 if ageRequired is empty
			if ( empty( $clipData['ageRequired'] ) ) {
				$clipData['ageRequired'] = 17;
			}
		}

		// set language
		if ( empty( $clip['LanguageName'] ) || $clip['LanguageName'] == 'Not Set'  ) {
			$clipData['language'] = 'English';
		} else {
			$clipData['language'] = $clip['LanguageName'];
		}

		// set distributor
		$clipData['distributor'] = empty( $clip['Studio'] ) ? '' : $clip['Studio'];

		$clipData['provider'] = 'screenplay';

		wfProfileOut( __METHOD__ );

		return $clipData;
	}

	/**
	 * Generate video name
	 * @return string $name
	 */
	protected function generateName() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->videoData['description'] ) ) {
			$altDescription = '';
			$altDescription .= empty( $this->videoData['category'] ) ? '' : $this->videoData['category'].' ';
			$altDescription .= empty( $this->videoData['type'] ) ? '' : $this->videoData['type'].' ';
			$description = $altDescription;
		} else {
			$description = $this->videoData['description'];
		}

		if ( startsWith( $description, 'Trailer ' ) ) {
			// add trailer type to description
			if ( !empty( $this->videoData['category'] ) ) {
				$description = $this->videoData['category'] . ' ' . $description;
			}
		}

		$name = sprintf( "%s - %s", $this->generateTitleName( $this->videoData ), $description );

		wfProfileOut( __METHOD__ );

		return $name;
	}

	public function generateTitleName( $data ) {
		$name = '';
		if ( strpos( $data['titleName'], "({$data['year']})" ) === false ) {
			$name = $data['titleName'] . ' (' . $data['year'] . ')';
		} else {
			$name = $data['titleName'];
		}

		return $name;
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $addlCategories
	 * @return array $categories
	 */
	public function generateCategories( array $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$addlCategories[] = $this->videoData['name'];

		if ( !empty( $this->videoData['type'] ) ) {
			$addlCategories[] = $this->getPageCategory( $this->videoData['type'] );
		}

		$addlCategories = array_merge( $addlCategories, $this->getAdditionalPageCategories( $addlCategories ) );

		// add language
		if ( !empty( $this->videoData['language'] ) && !preg_match( "/\benglish\b/i", $this->videoData['language'] ) ) {
			$addlCategories[] = 'International';
			$addlCategories[] = $this->videoData['language'];
		}

		if ( preg_match( '\(VG\)', $this->videoData['titleName'] ) !== false ) {
			$addlCategories[] = 'Games';
		} else {
			$addlCategories[] = 'Entertainment';
		}

		$addlCategories[] = 'Screenplay';

		wfProfileOut( __METHOD__ );

		return preg_replace( '/\s*,\s*/', ' ', wfGetUniqueArrayCI( $addlCategories ) );
	}

	/**
	 * Generate metadata
	 * @throws FeedIngesterSkippedException
	 * @return array
	 */
	public function generateMetadata() {
		if ( empty( $this->videoData['stdBitrateCode'] ) ) {
			throw new FeedIngesterSkippedException('No supported bitrate code for video id ' . $this->videoData['videoId']);
		}

		$metadata = parent::generateMetadata();
		$metadata['stdBitrateCode'] = $this->getVideoData( 'stdBitrateCode' );
		$metadata['jpegBitrateCode'] = $this->getVideoData( 'jpegBitrateCode' );
		$metadata['streamUrl'] = $this->getVideoData( 'streamUrl' );
		$metadata['streamHdUrl'] = $this->getVideoData( 'streamHdUrl' );
		$metadata['distributor'] = $this->getVideoData( 'distributor' );

		return $metadata;
	}

	/**
	 * Massage some video metadata and generate URLs to this video's assets
	 * @param boolean $generateUrl
	 */
	public function prepareMetaDataForOoyala( $generateUrl = true ) {
		$this->metaData['assetTitle'] = $this->metaData['destinationTitle'];
		$this->metaData['duration'] = $this->metaData['duration'] * 1000;
		$this->metaData['published'] = empty( $this->metaData['published'] ) ? '' : strftime( '%Y-%m-%d', $this->metaData['published'] );

		if ( $generateUrl ) {
			$url = empty( $this->metaData['streamUrl'] ) ? $this->metaData['streamHdUrl'] : $this->metaData['streamUrl'];
			$this->metaData['url'] = [
				'flash' => $url,
				'iphone' => $url,
			];
		}
	}

}