<?php

class ScreenplayFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'ScreenplayApiWrapper';
	protected static $PROVIDER = 'screenplay';
	protected static $FEED_URL = 'https://secure.totaleclips.com/WebServices/GetDataFeed.aspx?customerId=$1&username=$2&password=$3&startDate=$4&endDate=$5';
	protected static $CLIP_TYPE_BLACKLIST = array();

	public function downloadFeed( $startDate, $endDate ) {
		wfProfileIn( __METHOD__ );

		$url = $this->initFeedUrl( $startDate, $endDate );

		print( "Connecting to $url...\n" );

		$xmlContent = $this->getUrlContent( $url );

		if ( !$xmlContent ) {
			print( "ERROR: problem downloading content!\n" );
			wfProfileOut( __METHOD__ );
			return 0;
		}

		wfProfileOut( __METHOD__ );

		return $xmlContent;
	}

	/**
	 * get feed url
	 * @param string $startDate
	 * @param string $endDate
	 * @return string $url
	 */
	private function initFeedUrl( $startDate, $endDate ) {
		global $wgScreenplayApiConfig;

		$url = str_replace( '$1', $wgScreenplayApiConfig['customerId'], static::$FEED_URL );
		$url = str_replace( '$2', $wgScreenplayApiConfig['username'], $url );
		$url = str_replace( '$3', $wgScreenplayApiConfig['password'], $url );
		$url = str_replace( '$4', $startDate, $url );
		$url = str_replace( '$5', $endDate, $url );

		return $url;
	}

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$debug = !empty( $params['debug'] );
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];

		$articlesCreated = 0;

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$titles = $doc->getElementsByTagName( 'Title' );
		$numTitles = $titles->length;
		print( "Found $numTitles titles...\n" );
		for ( $i = 0; $i < $numTitles; $i++ ) {
			$title = $titles->item( $i );
			$titleName = html_entity_decode( $title->getElementsByTagName('TitleName')->item(0)->textContent );

			if ( !empty( $params['keyphrasesCategories'] ) ) {
				$addlCategories = array();
				foreach ( $params['keyphrasesCategories'] as $keyphrase => $categories ) {
					if ( $this->isKeyphraseInString( $titleName, $keyphrase ) ) {
						$addlCategories = array_merge( $addlCategories, $categories );
					}
				}
				if ( empty( $addlCategories ) ) {
					// keep going. If this title has Movie Trailer clips, ingest them
				}
			}

			$year = $title->getElementsByTagName('Year')->item(0)->textContent;
			$dateAdded = $title->getElementsByTagName('DateAdded')->item(0)->textContent;
			$clips = $title->getElementsByTagName('Clip');
			$numClips = $clips->length;
			$origAddlCategories = $addlCategories;
			for ($j = 0; $j < $numClips; $j++) {
				$addlCategories = $origAddlCategories;
				$clipData = array(
					'titleName' => $titleName,
					'year'      => $year,
					'published' => strtotime( $dateAdded ),
				);

				$clipData['name'] = $titleName;

				$clip = $clips->item($j);
				$clipData['category'] = $this->getCategory( $clip->getElementsByTagName('TrailerType')->item(0)->textContent );
				$clipData['type'] = $this->getStdType( $clip->getElementsByTagName('TrailerVersion')->item(0)->textContent );
				if ( empty( $addlCategories ) ) {
					if ( strtolower( $clipData['type'] ) == 'trailer'
						&& ( strtolower( $clipData['category'] ) != 'games' && stripos( $clipData['titleName'], '(VG)' ) === false ) ) {
						$addlCategories[] = 'Movie Trailers';
					}
				}

				$clipData['videoId'] = $clip->getElementsByTagName('EclipId')->item(0)->textContent;

				// If array is not empty - use only videos that exists in $this->filterByProviderVideoId array
				if ( count( $this->filterByProviderVideoId ) > 0 && !in_array( $clipData['videoId'], $this->filterByProviderVideoId ) ) {
					continue;
				}

				$clipData['description'] = html_entity_decode( $clip->getElementsByTagName('Description')->item(0)->textContent );
				$clipData['duration'] = $clip->getElementsByTagName('RunTime')->item(0)->textContent;

				// check Trailer Rating first. if not found, check MPAA Rating
				$trailerRating = $this->getIndustryRating( $clip->getElementsByTagName('TrailerRating')->item(0)->textContent );
				if ( !empty( $trailerRating ) && $trailerRating != 'NR' ) {
					$clipData['industryRating'] = $trailerRating;
				} else if ( !empty( $clip->getElementsByTagName('MPAARating')->item(0)->textContent ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $clip->getElementsByTagName('MPAARating')->item(0)->textContent );
				}

				// set age required if ageGate is set
				$ageGate = $clip->getElementsByTagName('AgeGate')->item(0)->textContent;
				if  ( $ageGate && strtolower( $ageGate ) == "true" ) {
					$clipData['ageGate'] = 1;
					$clipData['ageRequired'] = $this->getAgeRequired( $clipData['industryRating'] );
					// set age required to 18 if ageRequired is empty
					if ( empty( $clipData['ageRequired'] ) ) {
						$clipData['ageRequired'] = 18;
					}
				} else {
					$clipData['ageGate'] = 0;
					$clipData['ageRequired'] = 0;
				}

				$clipData['language'] = $clip->getElementsByTagName('Language')->item(0)->textContent;
				$clipData['jpegBitrateCode'] = ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID;
				$clipData['streamUrl'] = '';
				$clipData['streamHdUrl'] = '';

				$encodes = $clip->getElementsByTagName('Encode');
				$numEncodes = $encodes->length;
				for ( $k = 0; $k < $numEncodes; $k++ ) {
					$encode = $encodes->item($k);
					$url = html_entity_decode( $encode->getElementsByTagName('Url')->item(0)->textContent );
					$bitrateCode = $encode->getElementsByTagName('EncodeBitRateCode')->item(0)->textContent;
					$formatCode = $encode->getElementsByTagName('EncodeFormatCode')->item(0)->textContent;
					switch ( $formatCode ) {
						case ScreenplayApiWrapper::ENCODEFORMATCODE_JPEG:
							switch ( $bitrateCode ) {
								case ScreenplayApiWrapper::LARGE_JPEG_BITRATE_ID:
									$clipData['jpegBitrateCode'] = ScreenplayApiWrapper::LARGE_JPEG_BITRATE_ID;
									break;
								case ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID:
								default:
							}
							break;
						case ScreenplayApiWrapper::ENCODEFORMATCODE_MP4:
							switch ( $bitrateCode ) {
								case ScreenplayApiWrapper::STANDARD_BITRATE_ID:
								case ScreenplayApiWrapper::STANDARD_43_BITRATE_ID:
								case ScreenplayApiWrapper::STANDARD2_BITRATE_ID:
									$clipData['stdBitrateCode'] = $bitrateCode;
									$clipData['streamUrl'] = $url;
									break;
								case ScreenplayApiWrapper::HIGHDEF_BITRATE_ID:
									$clipData['streamHdUrl'] = $url;
									break;
								default:
							}
							break;
						default:
					}
				}

				$clipData['hd'] = empty( $clipData['streamHdUrl'] ) ? 0 : 1;
				$clipData['provider'] = 'screenplay';

				$msg = '';
				if ( $this->isClipTypeBlacklisted( $clipData ) ) {
					if ( $debug ) {
						print "Skipping {$clipData['titleName']} ({$clipData['year']}) - {$clipData['description']}. On clip type blacklist\n";
					}
				} else {
					$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug );
					$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
				}
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	protected function generateName( $data ) {
		wfProfileIn( __METHOD__ );

		$altDescription = '';
		$altDescription .= !empty( $data['category'] ) ? $data['category'] . ' ' : '';
		$altDescription .= !empty( $data['type'] ) ? $data['type'] . ' ' : '';
		//$altDescription .= "({$data['videoId']})";
		$description = ( $data['description'] ) ? $data['description'] : $altDescription;
		if ( startsWith( $description, 'Trailer ' ) ) {
			// add trailer type to description
			if ( !empty( $data['category'] ) ) {
				$description = $data['category'] . ' ' . $description;
			}
		}
		$name = sprintf( "%s - %s", $this->generateTitleName( $data ), $description );

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
	 * @param array $data
	 * @param array $categories
	 * @return array $categories
	 */
	public function generateCategories( $data, $categories ) {
		wfProfileIn( __METHOD__ );

		$categories[] = 'Screenplay, Inc.';
		$categories[] = $data['name'];

		if ( !empty( $data['type'] ) ) {
			$categories[] = $this->getStdPageCategory( $data['type'] );
		}

		// add language
		if ( !empty( $data['language'] ) && strtolower( $data['language'] ) != 'english' ) {
			$categories[] = 'International';
			$categories[] = $data['language'];
		}

		if ( stripos( $data['titleName'], '(VG)' ) !== false ) {
			$categories[] = 'Games';
		} else {
			$categories[] = 'Entertainment';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	/**
	 * generate metadata
	 * @param array $data
	 * @param string $errorMsg
	 * @return array|int $metadata or 0 on error
	 */
	public function generateMetadata( $data, &$errorMsg ) {
		//error checking
		if ( empty( $data['stdBitrateCode'] ) ) {
			$errorMsg = 'no supported bitrate code for video id ' . $data['videoId'];
			return 0;
		}

		$metadata = parent::generateMetadata( $data, $errorMsg );
		if ( empty( $metadata ) ) {
			return 0;
		}

		$metadata['stdBitrateCode'] = $data['stdBitrateCode'];
		$metadata['jpegBitrateCode'] = empty( $data['jpegBitrateCode'] ) ? '' : $data['jpegBitrateCode'];
		$metadata['streamUrl'] = empty( $data['streamUrl'] ) ? '' : $data['streamUrl'];
		$metadata['streamHdUrl'] = empty( $data['streamHdUrl'] ) ? '' : $data['streamHdUrl'];

		return $metadata;
	}

}