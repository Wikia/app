<?php

/**
 * Class CrunchyrollFeedIngester
 */
class CrunchyrollFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'CrunchyrollApiWrapper';
	protected static $PROVIDER = 'crunchyroll';
	protected static $FEED_URL = 'https://www.crunchyroll.com/syndication/feed?type=series';

	/**
	 * Contains desired series titles and Ids
	 * @var array
	 */
	private static $VIDEO_SERIES = [
		'Another' => [ 240622 ],
		'Attack on Titan' => [ 254209 ],
		'Bleach' => [ 42854 ],
		'Fate Zero' => [ 238014 ],
		'Gargantia on the Verdurous Planet' => [ 254063 ],
		'Golden Time' => [ 257145 ],
		'Hunter x Hunter' => [ 237800 ],
		'JoJo\'s Bizarre Adventure' => [ 260407 ],
		'Kill la Kill' => [ 257137 ],
		'My Teen Romantic Comedy SNAFU' => [ 253981 ],
		'Naruto' => [ 42850 ],
		'Naruto Shippuden' => [ 42852 ],
		'One Piece' => [ 257631 ],
		'Saint Seiya Hades' => [ 260965 ],
		'Saint Seiya Omega' => [ 244002 ],
		'Saint Seiya The Lost Canvas' => [ 224831 ],
		'Sword Art Online' => [ 246948 ],
		'The Pet Girl of Sakurasou' => [ 249482 ],
		'WATAMOTE' => [ 255741 ],
	];

	/**
	 * Get a flat list of all serie Ids that we must ingest
	 * @return array
	 */
	public function getAllSeriesIds() {
		$ids = [];
		foreach ( self::$VIDEO_SERIES as $videoSerie ) {
			$ids = array_merge( $ids, array_values( $videoSerie ) );
		}

		return array_unique( $ids );
	}

	/**
	 * Download content of given feed
	 * @param $feedUrl
	 * @return int|string|void
	 */
	public function downloadCollectionFeed( $feedUrl ) {
		return $this->download( $feedUrl );
	}

	/**
	 * Download content of class' feed URL
	 * @return int|string
	 */
	public function downloadFeed() {
		global $wgCrunchyrollConfig;

		$url = str_replace( '$1', $wgCrunchyrollConfig['affiliate_code'], static::$FEED_URL );
		return $this->download( $url );
	}

	/**
	 * Downloads feed and return it (return 0 on failure)
	 * @param string $feedUrl
	 * @return int|string
	 */
	public function download( $feedUrl ) {
		wfProfileIn( __METHOD__ );

		print( "Connecting to $feedUrl ...\n" );

		$content = $this->getUrlContent( $feedUrl );

		if ( !$content ) {
			$this->logger->videoErrors( "ERROR: problem downloading content.\n" );
			$content = 0;
		}

		wfProfileOut( __METHOD__ );

		return $content;
	}

	/**
	 * Retrieve all collection feeds applicable
	 * This will return an array of feed links for each collection
	 * @return array|void
	 */
	public function getCollectionFeeds() {
		wfProfileIn( __METHOD__ );

		$collectionFeeds = [];

		$content = $this->downloadFeed();
		if ( empty( $content ) ) {
			wfProfileOut( __METHOD__ );
			return $collectionFeeds;
		}

		$seriesIds = $this->getAllSeriesIds();
		$leadingString = '/series-';

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$items = $doc->getElementsByTagName( 'item' );

		foreach ( $items as $item ) {
			$seriesGuid = $item->getElementsByTagName( 'series-guid' )->item( 0 )->textContent;
			$serieId = explode( $leadingString, $seriesGuid );
			if ( empty( $serieId[1] ) ) {
				continue;
			}

			// Filter out series we are not interested in
			if ( !in_array( intval( $serieId[1] ), $seriesIds ) ) {
				continue;
			}

			// TODO: Filter out not-recently-modified feeds for better efficiency

			$collectionFeeds[] = urldecode( $item->getElementsByTagName( 'link' )->item( 0 )->textContent );
		}

		wfProfileOut( __METHOD__ );

		return array_unique( $collectionFeeds );
	}

	/**
	 * @inheritdoc
	 */
	public function import( $content = '', array $params = [] ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;

		foreach ( $this->getCollectionFeeds() as $collectionFeed ) {
			$content = $this->downloadCollectionFeed( $collectionFeed );
			if ( empty( $content ) ) {
				continue;
			}

			$doc = new DOMDocument( '1.0', 'UTF-8' );
			@$doc->loadXML( $content );
			$items = $doc->getElementsByTagName( 'item' );
			$numItems = $items->length;
			$this->logger->videoFound( $numItems );

			$elements = $doc->getElementsByTagName( 'language' );
			if ( $elements->length > 0 ) {
				$language = $this->convertLanguageCode( $elements->item( 0 )->textContent );
			} else {
				$language = '';
			}

			for ( $i = 0; $i < $numItems; ++$i ) {
				$clipData = [];
				$item = $items->item( $i );

				$clipData['series'] = $item->getElementsByTagName( 'seriesTitle' )->item( 0 )->textContent;

				// check for video name
				$elements = $item->getElementsByTagName( 'title' );
				if ( $elements->length > 0 ) {
					$clipData['titleName'] = $clipData['series'] . ' - ' . html_entity_decode( $elements->item( 0 )->textContent );
				} else {
					$this->logger->videoSkipped();
					continue;
				}

				// Skip the premium videos - free publish date for them is in the future
				$elements = $item->getElementsByTagName( 'freePubDate' );
				if ( $elements->length > 0 ) {
					$freePublishDate = strtotime( $elements->item( 0 )->textContent );
					if ( $freePublishDate > time() ) {
						$this->logger->videoSkipped( "\nPremium video (title: {$clipData['titleName']})\n" );
						continue;
					}
				}

				if ( WikiaFileHelper::getVideoFileFromTitle( $clipData['titleName'] ) ) {
					$this->logger->videoSkipped( "\nDuplicate video (title: {$clipData['titleName']})\n" );
					continue;
				}

				$clipData['name'] = $clipData['titleName'];

				$elements = $item->getElementsByTagName( 'description' );
				if ( $elements->length > 0 ) {
					$clipData['description'] = trim( strip_tags( $elements->item( 0 )->textContent ) );
				} else {
					$clipData['description'] = '';
				}

				// check for video id
				$elements = $item->getElementsByTagName( 'mediaId' );
				if ( $elements->length > 0 ) {
					$clipData['videoId'] = (int) $elements->item( 0 )->textContent;
				}

				if ( !isset( $clipData['videoId'] ) ) {
					$this->logger->videoWarnings( "ERROR: videoId NOT found for {$clipData['titleName']} - {$clipData['description']}.\n" );
					continue;
				}

				if ( empty( $clipData['videoId'] ) ) {
					$this->logger->videoWarnings( "ERROR: Empty videoId for {$clipData['titleName']} - {$clipData['description']}.\n" );
					continue;
				}

				// check for nonadult videos
				$elements = $item->getElementsByTagName( 'rating' );
				$clipData['ageGate'] = ( $elements->length > 0 && $elements->item( 0 )->textContent == 'nonadult' ) ? 0 : 1;

				if ( $clipData['ageGate'] ) {
					print( "Adult video: {$clipData['titleName']} ({$clipData['videoId']}).\n" );
					$clipData['ageRequired'] = '13';
					$clipData['industryRating'] = 'PG-13';
				}

				$clipData['published'] = strtotime( $item->getElementsByTagName( 'pubDate' )->item( 0 )->textContent );
				$clipData['publisher'] = $item->getElementsByTagName( 'publisher' )->item( 0 )->textContent;
				$clipData['expirationDate'] = strtotime( $item->getElementsByTagName( 'freeEndPubDate' )->item( 0 )->textContent );
				$clipData['videoUrl'] = urldecode( $item->getElementsByTagName( 'link' )->item( 0 )->textContent );

				$subTitleLangs = $item->getElementsByTagName( 'subtitleLanguages' );
				if ( $subTitleLangs->length > 0 ) {
					$clipData['subtitle'] = $this->convertSubtitleLanguageCode(
						$item->getElementsByTagName( 'subtitleLanguages' )->item( 0 )->textContent
					);
				}

				$clipData['regionalRestrictions'] = strtoupper(
					str_replace( ' ', ', ', $item->getElementsByTagName( 'restriction' )->item( 0 )->textContent )
				);

				$elements = $item->getElementsByTagName( 'season' );
				if ( $elements->length > 0 ) {
					$clipData['season'] = 'Season ' . $elements->item( 0 )->textContent;
				} else {
					$clipData['season'] = '';
				}

				$elements = $item->getElementsByTagName( 'episodeNumber' );
				if ( $elements->length > 0 ) {
					$clipData['episode'] = 'Episode ' . $elements->item( 0 )->textContent;
				} else {
					$clipData['episode'] = '';
				}

				// The first thumbnail returned by crunchyroll is the largest one - get that!
				$elements = $item->getElementsByTagName( 'thumbnail' );
				$clipData['thumbnail'] = ( $elements->length > 0 ) ? $elements->item( 0 )->getAttribute( 'url' ) : '';

				$elements = $item->getElementsByTagName( 'keywords' );
				$clipData['keywords'] = ( $elements->length > 0 ) ? $elements->item( 0 )->textContent : '';

				$elements = $item->getElementsByTagName( 'category' );
				if ( $elements->length > 0 ) {
					$clipData['category'] = $this->getCategory( $elements->item( 0 )->textContent );
				}

				$clipData['language'] = $language;
				$clipData['duration'] = $item->getElementsByTagName( 'duration' )->item( 0 )->textContent;
				$clipData['hd'] = 0;
				$clipData['provider'] = 'crunchyroll';

				$articlesCreated += $this->createVideo( $clipData );
			}
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

		$addlCategories[] = 'Anime';
		$addlCategories[] = 'Crunchyroll';
		$addlCategories[] = $this->videoData['series'];
		$addlCategories[] = 'Entertainment';
		if ( !empty( $this->videoData['season'] ) ) {
			$addlCategories[] = $this->videoData['series'] . ': ' . $this->videoData['season'];
		}

		wfProfileOut( __METHOD__ );

		return wfGetUniqueArrayCI( $addlCategories );
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
	 * Converts the language code Crunchyroll uses to Wikia's
	 * @param string $crunchyLanguage
	 * @return null|string
	 */
	protected function convertLanguageCode( $crunchyLanguage ) {
		$lang = explode( '-', $crunchyLanguage );
		return $this->getCLDRCode( $lang[0], 'language', false );
	}

	/**
	 * Normalize subtitle language code Crunchyroll uses
	 * @param string $crunchySubtitles
	 * @return null|string
	 */
	protected function convertSubtitleLanguageCode( $crunchySubtitles ) {
		$wikiaLangs = [];
		$subs = explode( ',', $crunchySubtitles );

		foreach ( $subs as $sub ) {
			$wikiaLangs[] = $this->convertLanguageCode( $sub );
		}

		return implode( ', ', array_unique( $wikiaLangs ) );
	}

}