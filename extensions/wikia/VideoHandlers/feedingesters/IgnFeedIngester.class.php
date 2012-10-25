<?php

class IgnFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IgnApiWrapper';
	protected static $PROVIDER = 'ign';
	//protected static $FEED_URL = 'http://apis.ign.com/partners/wikia/video/v3/videos?fromDate=$1&toDate=$2';
	protected static $FEED_URL = 'http://apis.ign.com/partners/v3/wikia?fromDate=$1&toDate=$2';
	protected static $CLIP_TYPE_BLACKLIST = array();

	/*
	 * Public functions
	*/

	public function downloadFeed($startDate, $endDate) {

		wfProfileIn( __METHOD__ );
		$url = $this->initFeedUrl($startDate, $endDate);

		print("Connecting to $url...\n");

		$content = $this->getUrlContent($url);

		if (!$content) {
			print("ERROR: problem downloading content!\n");
			wfProfileOut( __METHOD__ );
			return 0;
		}

		wfProfileOut( __METHOD__ );
		return $content;
	}

	/**
	 * @param $keywords string with comma-separated keywords
	 * @return string regexp or null if no valid keywords were specified
	 */
	private function prepare_blacklist_regexp($keywords) {
		if ($keywords) {
			$keywords = explode(',', $keywords);
			$blacklist = array();
			foreach($keywords as $word) {
				$word = preg_replace("/[^A-Za-z0-9' ]/", "", trim($word) );
				if ($word) $blacklist[] = $word;
			}
			if (!empty($blacklist)) {
				return '/\b('.implode('|', $blacklist).')\b/i';
			}
		}
		return null;
	}

	public function import($content='', $params=array()) {

		wfProfileIn( __METHOD__ );

		$debug = !empty($params['debug']);
		$ignoreRecent = !empty($params['ignorerecent']) ? $params['ignorerecent'] : 0;

		$articlesCreated = 0;

		$content = json_decode($content, true);
		if(empty($content)) $content = array();

		$i = 0;
		foreach($content as $video) {
			$i++;
			$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();

			if($debug) {
				print "\nraw data: \n";
				foreach( explode("\n", var_export($video, 1)) as $line ) {
					print ":: $line\n";
				}
			}

			$clipData = array();

			/*
             * If array is not empty - use only videos that exists in $this->filterByProviderVideoId array
             */
			if ( count($this->filterByProviderVideoId)>0 && !in_array( $video['videoId'], $this->filterByProviderVideoId ) ) {
				continue;
			}

			$clipData['titleName'] = $video['metadata']['name'];
			$clipData['publishDate'] = $video['metadata']['publishDate'];
			$clipData['videoId'] = $video['videoId'];
			$clipData['description'] = isset($video['metadata']['description']) ? $video['metadata']['description'] : '';
			$clipData['duration'] =  isset($video['metadata']['duration']) ? $video['metadata']['duration'] : '';
			$clipData['thumbnail'] =  $video['metadata']['thumbnail'];
			$clipData['videoUrl'] =  $video['metadata']['url'];
			$clipData['classification'] = $video['metadata']['classification'];
			$clipData['gameContent'] = $video['metadata']['gameContent'];
			if( isset($video['metadata']['ageGate']) ) {
				$clipData['ageGate'] = $video['metadata']['ageGate'];
			} else {
				$clipData['ageGate'] = 0;
			}
			$clipData['highDefinition'] = $video['metadata']['highDefinition'];

			$keywords = array();
			foreach( $video['objectRelations'] as $obj ) {
				$keywords[$obj['objectName']] = true;
			}
			$keywords = array_keys( $keywords );
			$addlCategories = array_merge( $addlCategories, $keywords );
			$clipData['keywords'] = implode(", ", $keywords );

			$blacklist_regexp = $this->prepare_blacklist_regexp(F::app()->wg->IgnVideoBlacklist);
			if ($blacklist_regexp) {
				foreach(array('keywords', 'titleName', 'description') as $key) {
					if (preg_match($blacklist_regexp, $clipData[$key])) {
						echo "Blacklisting video ! ".$clipData['titleName'].", videoId ".$clipData['videoId']." (reason $key: ".$clipData[$key].")\n";
						continue;
					}
				}
			}

			$tags = array();
			$blacklist_regexp = $this->prepare_blacklist_regexp(F::app()->wg->IgnKeywordsBlacklist);
			foreach( $video['tags'] as $obj ) {
				if (array_key_exists('slug', $obj)) {
					if ($blacklist_regexp && preg_match($blacklist_regexp, $obj['slug'])) {
						echo "Skipping blacklisted keyword ".$obj['slug']."\n";
						continue;
					}
					$tags[$obj['slug']] = true;
				}
			}
			$tags = array_keys( $tags );
			//$addlCategories = array_merge( $addlCategories, $tags );
			$clipData['tags'] = implode(", ", $tags );

			$createParams = array('addlCategories'=>$addlCategories, 'debug'=>$debug, 'ignorerecent'=>$ignoreRecent);
			$articlesCreated += $this->createVideo($clipData, $msg, $createParams);


		}
		echo "Feed size: $i\n";

		wfProfileOut( __METHOD__ );
		return $articlesCreated;
	}

	public function generateCategories(array $data, $addlCategories) {

		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'IGN';

		if(!empty($data['gameContent'])) {
			$categories[] = 'IGN_games';
			$categories[] = 'Games';
		} else {
			$categories[] = 'IGN_entertainment';
			$categories[] = 'Entertainment';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	/*
	 * Protected functions
	*/


	protected function generateName(array $data) {

		wfProfileIn( __METHOD__ );
		$name = $data['titleName'];

		wfProfileOut( __METHOD__ );
		return $name;
	}

	protected function generateMetadata(array $data, &$errorMsg) {
		//error checking
		if (empty($data['videoId'])) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata =
			array(
				'videoId'		=> $data['videoId'],
				'hd'			=> $data['highDefinition'],
				'duration'		=> $data['duration'],
				'published'		=> strtotime($data['publishDate']),
				'ageGate'		=> $data['ageGate'],
				'thumbnail'		=> $data['thumbnail'],
				'videoUrl'		=> $data['videoUrl'],
				'category'		=> $data['classification'],
				'description'	=> $data['description'],
				'keywords'		=> $data['keywords'],
				'tags'			=> $data['tags'],
			);
		return $metadata;
	}

	protected function getUrlContent($url) {
		global $wgIgnApiConfig;
		$options = array(
			'timeout'=>'default'
		);
		echo("Creating request\n");
		$req = HttpRequest::factory( $url, $options );
		$req->setHeader('X-App-Id',$wgIgnApiConfig['AppId']);
		$req->setHeader('X-App-Key', $wgIgnApiConfig['AppKey']);
		echo("Executing\n");
		$status = $req->execute();
		if ( $status->isOK() ) {
			echo("Got content\n");
			$ret = $req->getContent();
		} else {
			$errMsg = "Requested URL was: " . $req->getFinalUrl();
			$errMsg .= " (err: " . json_encode($req->status->errors) . ')';
			Wikia::log(__METHOD__, 'error', $errMsg);
			echo("No content\n".$errMsg);
			$ret = false;
		}
		return $ret;
	}

	/*
	 * Private functions
	*/


	private function initFeedUrl($startDate, $endDate) {
		$url = str_replace('$1', $startDate, static::$FEED_URL);
		$url = str_replace('$2', $endDate, $url);
		return $url;
	}


}