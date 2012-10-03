<?php

class ScreenplayFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'ScreenplayApiWrapper';
	protected static $PROVIDER = 'screenplay';
	protected static $FEED_URL = 'https://secure.totaleclips.com/WebServices/GetDataFeed.aspx?customerId=$1&username=$2&password=$3&startDate=$4&endDate=$5';
	protected static $CLIP_TYPE_BLACKLIST = array();

	public function downloadFeed($startDate, $endDate) {

		wfProfileIn( __METHOD__ );
		$url = $this->initFeedUrl($startDate, $endDate);

		print("Connecting to $url...\n");

		$xmlContent = $this->getUrlContent($url);

		if (!$xmlContent) {
			print("ERROR: problem downloading content!\n");
			wfProfileOut( __METHOD__ );
			return 0;
		}
		wfProfileOut( __METHOD__ );
		return $xmlContent;	
	}
	
	private function initFeedUrl($startDate, $endDate) {
		global $wgScreenplayApiConfig;
		
		$url = str_replace('$1', $wgScreenplayApiConfig['customerId'], static::$FEED_URL );
		$url = str_replace('$2', $wgScreenplayApiConfig['username'], $url);
		$url = str_replace('$3', $wgScreenplayApiConfig['password'], $url);
		$url = str_replace('$4', $startDate, $url);
		$url = str_replace('$5', $endDate, $url);
		return $url;
	}

	public function import($content='', $params=array()) {

		wfProfileIn( __METHOD__ );

		$debug = !empty($params['debug']);
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();

		$articlesCreated = 0;

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$titles = $doc->getElementsByTagName('Title');
		$numTitles = $titles->length;
		print("Found $numTitles titles...\n");
		for ($i=0; $i<$numTitles; $i++) {
			$title = $titles->item($i);
			$titleName = html_entity_decode( $title->getElementsByTagName('TitleName')->item(0)->textContent );

			if (!empty($params['keyphrasesCategories'])) {
				$addlCategories = array();
				foreach ($params['keyphrasesCategories'] as $keyphrase=>$categories) {
					if ($this->isKeyphraseInString($titleName, $keyphrase)) {
						$addlCategories = array_merge($addlCategories, $categories);
					}		
				}
				if (empty($addlCategories)) {
					// keep going. If this title has Movie Trailer clips, ingest them
				}
			}

			$year = $title->getElementsByTagName('Year')->item(0)->textContent;
			$dateAdded = $title->getElementsByTagName('DateAdded')->item(0)->textContent;
			$clips = $title->getElementsByTagName('Clip');
			$numClips = $clips->length;
			$origAddlCategories = $addlCategories;
			for ($j=0; $j<$numClips; $j++) {
				$addlCategories = $origAddlCategories;
				$clipData = array('titleName'=>$titleName, 'year'=>$year, 'dateAdded'=>$dateAdded);

				$clip = $clips->item($j);
				$clipData['trailerType'] = $clip->getElementsByTagName('TrailerType')->item(0)->textContent;
				$clipData['trailerVersion'] = $clip->getElementsByTagName('TrailerVersion')->item(0)->textContent;
				if (empty($addlCategories)) {
					if (strtolower($clipData['trailerVersion']) == 'trailer'
					&& (strtolower($clipData['trailerType']) != 'video game' && stripos($clipData['titleName'], '(VG)') === false)
					) {
						$addlCategories[] = 'Movie Trailers';
					}
				}
				if (strtolower($clipData['trailerType']) == 'not set') unset($clipData['trailerType']);
				if (strtolower($clipData['trailerVersion']) == 'not set') unset($clipData['trailerVersion']);
				$clipData['videoId'] = $clip->getElementsByTagName('EclipId')->item(0)->textContent;

				/*
				 * If array is not empty - use only videos that exists in $this->filterByProviderVideoId array
				 */
				if ( count($this->filterByProviderVideoId)>0 && !in_array( $clipData['videoId'], $this->filterByProviderVideoId ) ) {
					continue;
				}

				$clipData['description'] = html_entity_decode( $clip->getElementsByTagName('Description')->item(0)->textContent );
				$clipData['duration'] = $clip->getElementsByTagName('RunTime')->item(0)->textContent;
				$clipData['trailerRating'] = $clip->getElementsByTagName('TrailerRating')->item(0)->textContent;
				$clipData['industryRating'] = $clip->getElementsByTagName('MPAARating')->item(0)->textContent;
				$ageGate = $clip->getElementsByTagName('AgeGate')->item(0)->textContent;
				$clipData['ageGate'] = $ageGate && strtolower($ageGate) == "true";
				$clipData['language'] = $clip->getElementsByTagName('Language')->item(0)->textContent;
				$clipData['jpegBitrateCode'] = ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID;
				$clipData['stdMp4Url'] = '';
				$clipData['hdMp4Url'] = '';

				$encodes = $clip->getElementsByTagName('Encode');
				$numEncodes = $encodes->length;
				for ($k=0; $k<$numEncodes; $k++) {				
					$encode = $encodes->item($k);
					$url = html_entity_decode( $encode->getElementsByTagName('Url')->item(0)->textContent );					
					$bitrateCode = $encode->getElementsByTagName('EncodeBitRateCode')->item(0)->textContent;
					$formatCode = $encode->getElementsByTagName('EncodeFormatCode')->item(0)->textContent;
					switch ($formatCode) {
						case ScreenplayApiWrapper::ENCODEFORMATCODE_JPEG:
							switch ($bitrateCode) {
								case ScreenplayApiWrapper::LARGE_JPEG_BITRATE_ID:
									$clipData['jpegBitrateCode'] = ScreenplayApiWrapper::LARGE_JPEG_BITRATE_ID;
									break;
								case ScreenplayApiWrapper::MEDIUM_JPEG_BITRATE_ID:
								default:
							}
							break;
						case ScreenplayApiWrapper::ENCODEFORMATCODE_MP4:
							switch ($bitrateCode) {
								case ScreenplayApiWrapper::STANDARD_BITRATE_ID:
								case ScreenplayApiWrapper::STANDARD_43_BITRATE_ID:
								case ScreenplayApiWrapper::STANDARD2_BITRATE_ID:
									$clipData['stdBitrateCode'] = $bitrateCode;
									$clipData['stdMp4Url'] = $url;
									break;
								case ScreenplayApiWrapper::HIGHDEF_BITRATE_ID:
									$clipData['hdMp4Url'] = $url;
									break;
								default:
							}
							break;
						default:
					}
				}

				$msg = '';
				if ($this->isClipTypeBlacklisted($clipData)) {
					if ($debug) {
						print "Skipping {$clipData['titleName']} ({$clipData['year']}) - {$clipData['description']}. On clip type blacklist\n";
					}
				}
				else {
					$createParams = array('addlCategories'=>$addlCategories, 'debug'=>$debug);
					$articlesCreated += $this->createVideo($clipData, $msg, $createParams);
				}
				if ($msg) {
					print "ERROR: $msg\n";
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $articlesCreated;
	}

	protected function generateName(array $data) {

		wfProfileIn( __METHOD__ );
		$name = '';

		$altDescription = '';
		$altDescription .= !empty($data['trailerType']) ? $data['trailerType'] . ' ' : '';
		$altDescription .= !empty($data['trailerVersion']) ? $data['trailerVersion'] . ' ' : '';
		//$altDescription .= "({$data['videoId']})";
		$description = ($data['description']) ? $data['description'] : $altDescription;
		if (startsWith($description, 'Trailer ')) {
			// add trailer type to description
			if (!empty($data['trailerType'])) {
				$description = $data['trailerType'] . ' ' . $description;
			}
		}
		$name = sprintf("%s - %s", $this->generateTitleName($data), $description);

		wfProfileOut( __METHOD__ );
		return $name;
	}

	public function generateTitleName(array $data) {
		$name = '';
		
		if (strpos($data['titleName'], "({$data['year']})") === false) {
			$name = $data['titleName'] . ' (' . $data['year'] . ')';					
		}
		else {
			$name = $data['titleName'];					
		}
		
		return $name;		
	}
	
	public function generateCategories(array $data, $addlCategories) {

		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'Screenplay, Inc.';

		if (!empty($data['trailerVersion'])) {
			$categories[] = $data['trailerVersion'];
		}
		if (stripos($data['titleName'], '(VG)') !== false) {
			$categories[] = 'Games';
		}
		else {
			$categories[] = 'Entertainment';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}
	
	protected function generateMetadata(array $data, &$errorMsg) {
		//error checking
		if (empty($data['videoId'])) {
			$errorMsg = 'no video id exists';
			return 0;
		}
		if (empty($data['stdBitrateCode'])) {
			$errorMsg = 'no supported bitrate code for video id ' . $data['videoId'];
			return 0;
		}		
		
		$metadata = array();
		$doesHdExist = (int) !empty($data['hdMp4Url']);
		$metadata = 
			array(
			    'videoId'		=>	$data['videoId'],
			    'stdBitrateCode'	=>	$data['stdBitrateCode'],
			    'hd'		=>	$doesHdExist,
			    'duration'		=>	$data['duration'],
			    'jpegBitrateCode'	=>	$data['jpegBitrateCode'],
			    'published'		=>	strtotime($data['dateAdded']),
			    'trailerRating'	=>	$data['trailerRating'],
			    'industryRating'	=>	$data['industryRating'],
			    'ageGate'		=>	(int) $data['ageGate'],
			    'language'		=>	$data['language'],
				'streamUrl'		=>	$data['stdMp4Url'],
				'streamHdUrl'	=>	$data['hdMp4Url']
			    );
		return $metadata;
	}
}