<?php

class TwitchtvFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'TwitchtvApiWrapper';
	protected static $PROVIDER = 'twitchtv';
	protected static $FEED_URL = 'https://api.twitch.tv/kraken/videos/top?game=$1&limit=$2&offset=$3&period=$4';
	private static $VIDEO_SETS = array(
		'League of Legends',
	);

	const API_PAGE_SIZE = 100;

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$debug = !empty( $params['debug'] );
		$addlCategories = !empty( $params['addlCategories'] ) ? $params['addlCategories'] : array();
		$period = !empty( $params['startDate'] ) ? 'all' : 'week';

		$articlesCreated = 0;

		foreach( self::$VIDEO_SETS as $videoSet ) {
			$page = 0;
			do {
				// connect to provider API
				$url = $this->initFeedUrl( $videoSet, $page++, $period );
				print( "Connecting to $url...\n" );

				$req = MWHttpRequest::factory( $url );
				$status = $req->execute();
				if( $status->isOK() ) {
					$response = $req->getContent();
				} else {
					print( "ERROR: problem downloading content.\n" );
					wfProfileOut( __METHOD__ );

					return 0;
				}

				// parse response
				$response = json_decode( $response, true );
				$videos = ( empty( $response['videos'] ) ) ? array() : $response['videos'] ;
				$numVideos = count( $videos );

				print( "Found $numVideos videos...\n" );

				foreach( $videos as $video ) {
					$clipData = array();
					$clipData['titleName'] =  empty( $video['game'] ) ? '' : trim( $video['game'] );
					$clipData['titleName'] .=  empty( $video['title'] ) ? '' : ' - '.trim( $video['title'] );
					$clipData['videoId'] = $video['_id'];

					if ( empty($clipData['titleName'] ) ) {
						print "Skip: Id:{$clipData['videoId']} empty title.\n";
						continue;
					}

					$clipData['thumbnail'] = $video['preview'];
					$clipData['duration'] = $video['length'];
					$clipData['published'] = $video['recorded_at'];
					$clipData['category'] = 'videos';
					$clipData['ageGate'] = 0;
					$clipData['keywords'] = $video['game'];
					$clipData['description'] = trim( $video['description'] );
					$clipData['hd'] = 0;
					$clipData['tags'] = $videoSet;
					$clipData['provider'] = 'twitchtv';
					$clipData['language'] = '';
					$clipData['videoUrl'] = $video['url'];
					$clipData['channel'] = $video['channel']['name'];

					$msg = '';
					$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug );
					$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
					if ( $msg ) {
						print "ERROR: $msg\n";
					}
				}
			} while( $numVideos == self::API_PAGE_SIZE );
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	private function initFeedUrl( $videoSet, $page, $period ) {
		$url = str_replace( '$1', urlencode( $videoSet ), static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE, $url );
		$url = str_replace( '$3', ( $page * self::API_PAGE_SIZE ), $url );
		$url = str_replace( '$4', $period, $url );

		return $url;
	}

	public function generateCategories( array $data, $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$categories = !empty( $addlCategories ) ? $addlCategories : array();

		$categories[] = 'Twitch';
		$categories[] = 'Games';

		if ( !empty( $data['keywords'] ) ) {
			$keywords = explode( ',', $data['keywords'] );
			foreach( $keywords as $keyword ) {
				$categories[] = trim( $keyword );
			}
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	protected function generateName( array $data ) {
		wfProfileIn( __METHOD__ );

		$name = $data['titleName'];

		wfProfileOut( __METHOD__ );

		return $name;
	}

	protected function generateMetadata( array $data, &$errorMsg ) {
		if ( empty( $data['videoId'] ) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
			'videoId' => $data['videoId'],
			'hd' => $data['hd'],
			'duration' => $data['duration'],
			'published' => strtotime( $data['published'] ),
			'ageGate' => $data['ageGate'],
			'thumbnail' => $data['thumbnail'],
			'category' => $data['category'],
			'description' => $data['description'],
			'keywords' => $data['keywords'],
			'tags' => $data['tags'],
			'provider' => $data['provider'],
			'language' => $data['language'],
			'videoUrl' => $data['videoUrl'],
			'channel' => $data['channel'],
		);

		return $metadata;
	}

}