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

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;
		$debug = !empty( $params['debug'] );
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$items = $doc->getElementsByTagName( 'item' );
		$numItems = $items->length;
		print( "Found $numItems items...\n" );

		for ( $i = 0; $i < $numItems; $i++ ) {
			$item = $items->item( $i );

			// check for video name
			$elements = $item->getElementsByTagName( 'title' );
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
				foreach ( $elements->item(0)->getElementsByTagNameNS('http://search.yahoo.com/mrss/', 'param') as $element ) {
					if ( $element->getAttribute('name') == 'clipId' ) {
						$clipData['videoId'] = $element->textContent;
					}
				}
			}

			if ( !array_key_exists( 'videoId', $clipData ) ) {
				print "ERROR: videoId NOT found for {$clipData['titleName']} - {$clipData['description']}.\n";
				continue;
			}

			if ( empty( $clipData['videoId'] ) ) {
				print "ERROR: Empty videoId for {$clipData['titleName']} - {$clipData['description']}.\n";
				continue;
			}

			// check for nonadult videos
			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'rating' );
			$clipData['ageGate'] = ( $elements->length > 0 && $elements->item(0)->textContent == 'nonadult' ) ? 0 : 1;

			if ( $clipData['ageGate'] ) {
				print "SKIP: Skipping adult video: {$clipData['titleName']} ({$clipData['videoId']}).\n";
				continue;
			}

			$clipData['ageRequired'] = 0;

			$this->getTitleName( $clipData['titleName'], $clipData['videoId'] );

			$clipData['published'] = strtotime( $item->getElementsByTagName('pubDate')->item(0)->textContent );
			$clipData['videoUrl'] = $item->getElementsByTagName('link')->item(0)->textContent;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'thumbnail' );
			$clipData['thumbnail'] = ( $elements->length > 0 ) ? $elements->item(0)->getAttribute('url') : '' ;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'keywords' );
			$clipData['keywords'] = ( $elements->length > 0 ) ? $elements->item(0)->textContent : '' ;

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'category' );
			if ( $elements->length > 0 ) {
				$clipData['category'] = $this->getCategory( $elements->item(0)->textContent );
				if ( !empty( $clipData['category'] ) && $clipData['category'] == 'Movies' ) {
					$clipData['type'] = 'Clip';
				}

				$clipData['name'] = $elements->item(0)->getAttribute('label');
			}

			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'content' );
			if ( $elements->length > 0 ) {
				$clipData['language'] = $this->getCldrCode( $elements->item(0)->getAttribute('lang'), 'language', false );
				$clipData['duration'] = $elements->item(0)->getAttribute('duration');
			}

			$genres = array();
			$elements = $item->getElementsByTagName( 'genre' );
			foreach ( $elements as $element ) {
				$genres[] = $element->textContent;
			}
			$clipData['genres'] = implode( ', ', $genres );

			$actors = array();
			$elements = $item->getElementsByTagNameNS( 'http://search.yahoo.com/mrss/', 'credit' );
			foreach ( $elements as $element ) {
				if ( $element->getAttribute('role') == 'actor' ) {
					$actors[] = $element->textContent;
				}
			}
			$clipData['actors'] = implode( ', ', $actors );

			$clipData['hd'] = 0;
			$clipData['provider'] = 'anyclip';

			$msg = '';
			if ( $this->isClipTypeBlacklisted( $clipData ) ) {
				if ( $debug ) {
					print "Skipping {$clipData['titleName']} - {$clipData['description']}. On clip type blacklist\n";
				}
			} else {
				$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
			}

			if ( $msg ) {
				print "ERROR: $msg\n";
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $data
	 * @param array $categories
	 * @return array $categories
	 */
	public function generateCategories( $data, $categories ) {
		wfProfileIn( __METHOD__ );

		$categories[] = 'AnyClip';
		$categories[] = 'Entertainment';
		if ( stristr( $data['titleName'], 'trailer' ) ) {
			$categories[] = 'Trailers';
		}

		if ( !empty( $data['name'] ) ) {
			$categories[] = $data['name'];
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	/**
	 * generate metadata
	 * @param array $data
	 * @param sring $errorMsg
	 * @return array|int $metadata or 0 on error
	 */
	public function generateMetadata( $data, &$errorMsg ) {
		$metadata = parent::generateMetadata( $data, $errorMsg );
		if ( empty( $metadata ) ) {
			return 0;
		}

		$metadata['videoUrl'] = empty( $data['videoUrl'] ) ? '' : $data['videoUrl'];
		$metadata['uniqueName'] = empty( $data['uniqueName'] ) ? '' : $data['uniqueName'];

		return $metadata;
	}

	/**
	 * get title
	 * @param string $titleName
	 * @param string $code - video id
	 */
	protected function getTitleName( &$titleName, $code ) {
		wfProfileIn( __METHOD__ );

		$url = AnyclipApiWrapper::getApi( $code );
		$req = MWHttpRequest::factory( $url );
		$status = VideoHandlerHelper::wrapHttpRequest( $req );
		if( $status->isOK() ) {
			$response = $req->getContent();
			$content = json_decode( $response, true );

			$title = AnyclipApiWrapper::getClipName( $content );

			if ( !empty( $title ) ) {
				$titleName = $title;
			}
		}

		wfProfileOut( __METHOD__ );
	}

}