<?php

/**
 * Class IgnFeedIngester
 */
class IgnFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IgnApiWrapper';
	protected static $PROVIDER = 'ign';
	protected static $FEED_URL = 'http://apis.ign.com/partners/v3/wikia?fromDate=$1&toDate=$2';
	protected static $CLIP_TYPE_BLACKLIST = array( );
	protected static $CLIP_FILTER = array(
		'*' => array( '/IGN Daily/i',
					  '/IGN Weekly/i',
		),
	);

	/*
	 * Public functions
	*/

	/**
	 * Given a start date and an end date, download the set of matching videos from IGN
	 * @param $startDate - Start of availability range
	 * @param $endDate - End of availability range
	 * @return int|string - JSON feed data if successful, zero otherwise
	 */
	public function downloadFeed( $startDate, $endDate ) {

		wfProfileIn( __METHOD__ );
		$url = $this->initFeedUrl($startDate, $endDate);

		print("Connecting to $url...\n");

		$content = $this->getUrlContent($url);

		if ( !$content ) {
			print("ERROR: problem downloading content!\n");
			wfProfileOut( __METHOD__ );
			return 0;
		}

		wfProfileOut( __METHOD__ );
		return $content;
	}

	/**
	 * Import a list of videos
	 * @param string $content - JSON encoded data from the provider
	 * @param array $params - A list of additional parameters that affect import
	 * @return int - Returns the number of video created
	 */
	public function import($content='', $params=array()) {

		wfProfileIn( __METHOD__ );

		$debug = !empty($params['debug']);
		$ignoreRecent = !empty($params['ignorerecent']) ? $params['ignorerecent'] : 0;

		$articlesCreated = 0;

		$content = json_decode($content, true);
		if ( empty($content) ) $content = array();

		$i = 0;
		foreach ( $content as $video ) {
			$i++;
			$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();

			if ( $debug ) {
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
			if ( isset($video['metadata']['ageGate']) ) {
				$clipData['ageGate'] = $video['metadata']['ageGate'];
			} else {
				$clipData['ageGate'] = 0;
			}
			$clipData['highDefinition'] = $video['metadata']['highDefinition'];

			$keywords = array();
			foreach ( $video['objectRelations'] as $obj ) {
				$keywords[$obj['objectName']] = true;
			}
			$keywords = array_keys( $keywords );
			$addlCategories = array_merge( $addlCategories, $keywords );
			$clipData['keywords'] = implode(", ", $keywords );

			$tags = array();
			foreach ( $video['tags'] as $obj ) {
				if ( array_key_exists('slug', $obj) ) {
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

	/**
	 * Get the set of categories to set on the file page that will be created for this video
	 * @param array $data - Video metadata
	 * @param $addlCategories - Any additional categories to explicitly add
	 * @return array - An array of category names
	 */
	public function generateCategories(array $data, $addlCategories) {

		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'IGN';

		if ( !empty($data['gameContent']) ) {
			$categories[] = 'IGN_games';
			$categories[] = 'Games';
		} else {
			$categories[] = 'IGN_entertainment';
			$categories[] = 'Entertainment';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	/**
	 * Map the provider metadata onto our supported metadata fields
	 * @param array $data - Video metadata
	 * @param $errorMsg - Set to an error message if a problem occurs
	 * @return array|int - An array of metadata when successful, zero otherwise
	 */
	protected function generateMetadata(array $data, &$errorMsg) {
		//error checking
		if ( empty($data['videoId']) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
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

	/**
	 * Make an HTTP request to the URL given and return the content
	 * @param $url - URL to request
	 * @return mixed|string
	 */
	protected function getUrlContent($url) {
		global $wgIgnApiConfig;
		echo("Creating request\n");
		$req = curl_init();
		curl_setopt($req, CURLOPT_URL, $url);
		curl_setopt($req, CURLOPT_HTTPHEADER,
			array(
				 "X-App-Id: ".$wgIgnApiConfig['AppId'],
				 "X-App-Key: ".$wgIgnApiConfig['AppKey']
			)
		);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($req, CURLOPT_VERBOSE, 1);
		curl_setopt($req, CURLOPT_STDERR, STDOUT);
		$ret = curl_exec($req);
		if ( !curl_errno($req) ) {
			$info = curl_getinfo($req);
			echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "\n";
		} else {
			echo 'Curl error: ' . curl_error($req) . "\n";
		}

		curl_close($req);
		return $ret;
	}

	/*
	 * Private functions
	*/

	/**
	 * Inject variable parameters into the base IGN URL
	 * @param $startDate - Start date for content to ingest (format 2013-07-19T11:01:00-0800)
	 * @param $endDate - End date for content to ingest
	 * @return string - Return a valid feed URL
	 */
	private function initFeedUrl($startDate, $endDate) {
		$url = str_replace('$1', $startDate, static::$FEED_URL);
		$url = str_replace('$2', $endDate, $url);
		return $url;
	}
}