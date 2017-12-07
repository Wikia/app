<?php

/**
 * Class IgnFeedIngester
 */
class IgnFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IgnApiWrapper';
	protected static $PROVIDER = 'ign';
	protected static $FEED_URL = 'https://apis.ign.com/partners/v3/wikia?fromDate=$1&toDate=$2&app_id=$3&app_key=$4';
	protected static $CLIP_FILTER = [
		'*' => [
			'/IGN Daily/i',
			'/IGN Weekly/i',
		]
	];

	/**
	 * Given a start date and an end date, download the set of matching videos from IGN
	 * @param $startDate - Start of availability range
	 * @param $endDate - End of availability range
	 * @return int|string - JSON feed data if successful, zero otherwise
	 */
	public function downloadFeed( $startDate, $endDate ) {
		wfProfileIn( __METHOD__ );

		$url = $this->initFeedUrl( $startDate, $endDate );

		print( "Connecting to $url...\n" );

		$content = $this->getUrlContent( $url );
		if ( !$content ) {
			$this->logger->videoErrors( "ERROR: problem downloading content.\n" );
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
	public function import( $content = '', array $params = [] ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;

		$videos = json_decode( $content, true );
		if ( empty( $videos ) ) {
			$videos = [];
		}

		$this->logger->videoFound( count( $videos ) );

		foreach ( $videos as $video ) {

			if ( $this->debugMode() ) {
				print "\nraw data: \n";
				foreach( explode( "\n", var_export( $video, 1 ) ) as $line ) {
					print ":: $line\n";
				}
			}

			$clipData = [];
			$clipData['titleName'] = $video['metadata']['name'];
			$clipData['published'] = strtotime( $video['metadata']['publishDate'] );
			$clipData['videoId'] = $video['videoId'];
			$clipData['description'] = empty( $video['metadata']['description'] ) ? '' : $video['metadata']['description'];
			$clipData['duration'] =  empty( $video['metadata']['duration'] ) ?  '' : $video['metadata']['duration'];
			$clipData['thumbnail'] =  $video['metadata']['thumbnail'];
			$clipData['videoUrl'] =  $video['metadata']['url'];

			$clipData['type'] = '';
			if ( !empty( $video['metadata']['classification'] ) ) {
				$clipData['type'] = $this->getType( $video['metadata']['classification'] );
			}

			$clipData['gameContent'] = $video['metadata']['gameContent'];
			$clipData['category'] = empty( $clipData['gameContent'] ) ? 'Entertainment' : 'Games';
			$clipData['hd'] = empty( $video['metadata']['highDefinition'] ) ? 0 : 1;
			$clipData['provider'] = 'ign';

			if ( !empty( $video['metadata']['ageGate'] ) && is_numeric( $video['metadata']['ageGate'] ) ) {
				$clipData['ageRequired'] = $video['metadata']['ageGate'];
			} else {
				$clipData['ageRequired'] = 0;
			}
			$clipData['ageGate'] = empty( $clipData['ageRequired'] ) ? 0 : 1;

			// get name

			$name = [];
			foreach ( $video['objectRelations'] as $obj ) {
				$name[$obj['objectName']] = true;
			}
			$name = array_keys( $name );
			$clipData['name'] = implode( ', ', $name );

			// add name to page categories
			$addlCategories = $name;

			// add tags to keywords
			$keywords = [];
			foreach ( $video['tags'] as $obj ) {
				if ( array_key_exists( 'slug', $obj ) ) {
					$keywords[$obj['slug']] = true;
				}
			}
			$keywords = array_keys( $keywords );
			$clipData['keywords'] = implode( ", ", $keywords );

			$articlesCreated += $this->createVideo( $clipData, $addlCategories );
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $addlCategories
	 * @return array $categories
	 */
	public function generateCategories( array $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$addlCategories[] = 'IGN';

		if ( empty( $this->videoData['gameContent'] ) ) {
			$addlCategories[] = 'IGN_entertainment';
			$addlCategories[] = 'Entertainment';
		} else {
			$addlCategories[] = 'IGN_games';
			$addlCategories[] = 'Games';
		}

		wfProfileOut( __METHOD__ );

		return $addlCategories;
	}

	/**
	 * generate metadata
	 * @return array
	 */
	public function generateMetadata() {
		$metadata = parent::generateMetadata();
		$metadata['videoUrl'] = $this->getVideoData( 'videoUrl' );

		return $metadata;
	}

	/**
	 * Make an HTTP request to the URL given and return the content
	 * @param $url - URL to request
	 * @param $options - Not actually used. Just to keep consistent method signature with base class.
	 * @return mixed|string
	 */
	protected function getUrlContent( $url, $options = [] ) {
		global $wgIgnApiConfig;
		echo( "Creating request\n" );
		$req = curl_init();
		curl_setopt( $req, CURLOPT_URL, $url );
		curl_setopt( $req, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $req, CURLOPT_VERBOSE, 1 );
		curl_setopt( $req, CURLOPT_STDERR, STDOUT );
		$ret = curl_exec( $req );
		if ( !curl_errno( $req ) ) {
			$info = curl_getinfo( $req );
			echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "\n";
		} else {
			echo 'Curl error: ' . curl_error( $req ) . "\n";
		}

		curl_close( $req );
		return $ret;
	}

	/**
	 * Inject variable parameters into the base IGN URL
	 * @param $startDate - Start date for content to ingest (format 2013-07-19T11:01:00-0800)
	 * @param $endDate - End date for content to ingest
	 * @return string - Return a valid feed URL
	 */
	private function initFeedUrl( $startDate, $endDate ) {
		global $wgIgnApiConfig;

		$url = str_replace( '$1', $startDate, static::$FEED_URL );
		$url = str_replace( '$2', $endDate, $url );
		$url = str_replace( '$3', $wgIgnApiConfig['AppId'], $url );
		$url = str_replace( '$4', $wgIgnApiConfig['AppKey'], $url );

		return $url;
	}
}