<?php

class AnyclipFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'AnyclipApiWrapper';
	protected static $PROVIDER = 'anyclip';
	protected static $FEED_URL = 'https://mrss.anyclip.com/$1.xml';
	protected static $CLIP_TYPE_BLACKLIST = array();

	public function downloadFeed( $startDate ) {
		wfProfileIn( __METHOD__ );

		$url = $this->initFeedUrl( $startDate );

		print( "Connecting to $url...\n" );

		$content = $this->getUrlContent( $url );

		if ( !$content ) {
			print( "ERROR: problem downloading content!\n" );
			wfProfileOut( __METHOD__ );

			return 0;
		}

		wfProfileOut( __METHOD__ );

		return $content;
	}

	private function initFeedUrl( $getAllVideos ) {
		if ( $getAllVideos ) {
			$url = str_replace( '$1', 'full', static::$FEED_URL );
		} else {
			$url = str_replace( '$1', 'daily', static::$FEED_URL );
		}

		return $url;
	}

	public function import( $content='', $params=array() ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;
		$debug = !empty( $params['debug'] );
		$addlCategories = !empty( $params['addlCategories'] ) ? $params['addlCategories'] : array();

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$items = $doc->getElementsByTagName( 'item' );
		$numItems = $items->length;
		print( "Found $numItems items...\n" );

		for( $i=0; $i<$numItems; $i++ ) {
			$item = $items->item($i);

			// check for video name
			$elements = $item->getElementsByTagName('title');
			if ( $elements->length > 0 ) {
				$clipData['titleName'] = html_entity_decode( $elements->item(0)->textContent );
				$clipData['uniqueName'] = $clipData['titleName'];
			} else {
				continue;
			}

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'description' );
			$clipData['description'] = ( $elements->length > 0 ) ? $elements->item(0)->textContent : '' ;

			// check for video id
			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'embed' );
			if ( $elements->length > 0 ) {
				foreach( $elements->item(0)->getElementsByTagNameNS('http://search.yahoo.com/mrss/', 'param') as $element ) {
					if ( $element->getAttribute('name') == 'clipId' ) {
						$clipData['videoId'] = $element->textContent;
					}
				}
			}

			if ( !array_key_exists('videoId', $clipData) ) {
				print "ERROR: videoId NOT found for {$clipData['titleName']} - {$clipData['description']}.\n";
				continue;
			}

			if ( empty($clipData['videoId']) ) {
				print "ERROR: Empty videoId for {$clipData['titleName']} - {$clipData['description']}.\n";
				continue;
			}

			// check for nonadult videos
			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'rating' );
			$clipData['ageGate'] = ( $elements->length > 0 && $elements->item(0)->textContent == 'nonadult' ) ? 0 : 1;

			if ( $clipData['ageGate'] ) {
				print "ERROR: Skipping adult video: {$clipData['titleName']} ({$clipData['videoId']}) - {$clipData['description']}.\n";
				continue;
			}

			$this->getTitleName( $clipData['titleName'], $clipData['videoId'] );

			$clipData['published'] = $item->getElementsByTagName('pubDate')->item(0)->textContent;
			$clipData['videoUrl'] = $item->getElementsByTagName('link')->item(0)->textContent;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'thumbnail' );
			$clipData['thumbnail'] = ( $elements->length > 0 ) ? $elements->item(0)->getAttribute('url') : '' ;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'keywords' );
			$clipData['tags'] = ( $elements->length > 0 ) ? $elements->item(0)->textContent : '' ;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'category' );
			if ( $elements->length > 0 ) {
				$clipData['category'] = $elements->item(0)->textContent;
				$clipData['keywords'] = $elements->item(0)->getAttribute('label');
			}

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'content' );
			if ( $elements->length > 0 ) {
				$clipData['language'] = $elements->item(0)->getAttribute('lang');
				$clipData['duration'] = $elements->item(0)->getAttribute('duration');
			}

			$genres = array();
			$elements = $item->getElementsByTagName( 'genre' );
			foreach( $elements as $element ) {
				$genres[] = $element->textContent;
			}
			$clipData['genres'] = implode( ', ', $genres );

			$actors = array();
			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'credit' );
			foreach( $elements as $element ) {
				if ( $element->getAttribute('role') == 'actor' ) {
					$actors[] = $element->textContent;
				}
			}
			$clipData['actors'] = implode( ', ', $actors );

			$clipData['hd'] = 0;

			$msg = '';
			if ( $this->isClipTypeBlacklisted($clipData) ) {
				if ( $debug ) {
					print "Skipping {$clipData['titleName']} - {$clipData['description']}. On clip type blacklist\n";
				}
			} else {
				$createParams = array( 'addlCategories'=>$addlCategories, 'debug'=>$debug );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
			}

			if ( $msg ) {
				print "ERROR: $msg\n";
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	public function generateCategories(array $data, $addlCategories) {
		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'AnyClips';
		$categories[] = 'Entertainment';
		if ( isset($data['keywords']) && !empty($data['keywords']) ) {
			$categories[] = $data['keywords'];
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
		if ( empty($data['videoId']) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
			'videoId' => $data['videoId'],
			'hd' => $data['hd'],
			'duration' => $data['duration'],
			'published' => strtotime($data['published']),
			'ageGate' => $data['ageGate'],
			'thumbnail' => $data['thumbnail'],
			'videoUrl' => $data['videoUrl'],
			'category' => $data['category'],
			'description' => $data['description'],
			'keywords' => $data['keywords'],
			'tags' => $data['tags'],
			'language' => $data['language'],
			'genres' => $data['genres'],
			'actors' => $data['actors'],
			'uniqueName' => $data['uniqueName'],
		);

		return $metadata;
	}

	protected function getTitleName( &$titleName, $code ) {
		wfProfileIn( __METHOD__ );

		$url = $this->getApi( $code );
		$req = MWHttpRequest::factory( $url );
		$status = $req->execute();
		if( $status->isOK() ) {
			$response = $req->getContent();
			$content = json_decode( $response, true );
			if ( isset($content['name']) && !empty($content['name']) ) {
				$titleName = $content['name'];
			}
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getApi( $code ) {
		global $wgAnyclipApiConfig;

		$params = array(
			'cid' => $wgAnyclipApiConfig['AppId'],
			'format' => 'JSON',
		);
		$url = str_replace( '$1', $code, 'http://apis.anyclip.com/api/clip/$1/' );
		$params['sig'] = $this->getApiSig( $url, $params );
		$url .= '?'.http_build_query( $params );

		return $url;
	}

	protected function getApiSig( $url, $params ) {
		global $wgAnyclipApiConfig;

		$input = explode( '.com', $url );
		if ( !is_array($input) ) {
			return '';
		}

		$input = array_pop( $input );
		$params['appKey'] = $wgAnyclipApiConfig['AppKey'];
		ksort( $params );
		$input .= '?'.http_build_query( $params );

		return sha1( $input );
	}

}