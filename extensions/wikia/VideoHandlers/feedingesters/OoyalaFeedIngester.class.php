<?php

class OoyalaFeedIngester extends VideoFeedIngester {
	const API_PAGE_SIZE = 100;

	protected static $API_WRAPPER = 'OoyalaApiWrapper';
	protected static $PROVIDER = 'ooyala';
	protected static $FEED_URL = 'https://api.ooyala.com';

	public function import( $content = '', array $params = [] ) {
		$params['now'] = time();

		// by created date
		$params['cond'] = array(
			"created_at >= '$params[startDate]'",
			"created_at < '$params[endDate]'",
		);
		$articlesCreated = $this->importVideos( $params );

		// by time restrictions
		$params['cond'] = array(
			"created_at < '$params[startDate]'",
			"time_restrictions.start_date >= '$params[startDate]'",
			"time_restrictions.start_date < '".gmdate( 'Y-m-d H:i:s', $params['now'] )."'",
		);
		$articlesCreated += $this->importVideos( $params );

		return $articlesCreated;
	}

	/**
	 * import videos
	 * @param array $params
	 * @return integer $articlesCreated
	 */
	public function importVideos( $params = [] ) {
		wfProfileIn( __METHOD__ );

		$articlesCreated = 0;
		$nextPage = '';

		do {
			// connect to provider API
			$url = OoyalaAsset::getApiUrlAssets( self::API_PAGE_SIZE, $nextPage, $params['cond'] );
			print( "Connecting to $url...\n" );

			$response = OoyalaAsset::getApiContent( $url );
			if ( $response === false ) {
				$this->logger->videoErrors( "ERROR: problem downloading content.\n" );
				wfProfileOut( __METHOD__ );
				return 0;
			}

			$videos = empty( $response['items'] ) ? array() : $response['items'] ;
			$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'] ;

			$this->logger->videoFound( count( $videos ) );

			foreach ( $videos as $video ) {
				if ( !empty( $video['time_restrictions']['start_date'] ) && strtotime( $video['time_restrictions']['start_date'] ) > $params['now'] ) {
					$this->logger->videoSkipped( "Skipping {$video['name']} (Id:{$video['embed_code']}). Time restriction.\n" );
					continue;
				}

				$clipData = array();
				$clipData['titleName'] = trim( $video['name'] );
				$clipData['videoId'] = $video['embed_code'];
				$clipData['thumbnail'] = $video['preview_image_url'];
				$clipData['duration'] = $video['duration'] / 1000;
				$clipData['published'] = empty( $video['metadata']['published'] ) ? '' : strtotime( $video['metadata']['published'] );
				$clipData['name'] = empty( $video['metadata']['name'] ) ? '' : $video['metadata']['name'];
				$clipData['type'] = empty( $video['metadata']['type'] ) ? '' : $video['metadata']['type'];
				$clipData['category'] = empty( $video['metadata']['category'] ) ? '' : $this->getCategory( $video['metadata']['category'] );
				$clipData['keywords'] = empty( $video['metadata']['keywords'] ) ? '' : $video['metadata']['keywords'];
				$clipData['description'] = trim( $video['description'] );

				$clipData['ageRequired'] = empty( $video['metadata']['age_required'] ) ? 0 : $video['metadata']['age_required'];
				$clipData['ageGate'] = empty( $clipData['ageRequired'] ) ? 0 : 1;

				$clipData['hd'] = empty( $video['metadata']['hd'] ) ? 0 : 1;

				$clipData['industryRating'] = '';
				if ( !empty( $video['metadata']['industryrating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $video['metadata']['industryrating'] );
				}

				$clipData['categoryName'] = OoyalaApiWrapper::getProviderName( $video['labels'] );
				// check for videos under '/Providers/' labels
				if ( empty( $clipData['categoryName'] ) ) {
					$this->logger->videoSkipped( "Skipping {$clipData['titleName']} - {$clipData['description']}. No provider name.\n" );
					continue;
				}
				$clipData['provider'] = OoyalaApiWrapper::formatProviderName( $clipData['categoryName'] );

				$clipData['language'] =  empty( $video['metadata']['lang'] ) ? '' : $video['metadata']['lang'];
				$clipData['subtitle'] =  empty( $video['metadata']['subtitle'] ) ? '' : $video['metadata']['subtitle'];
				$clipData['genres'] = empty( $video['metadata']['genres'] ) ? '' : $video['metadata']['genres'];
				$clipData['actors'] = empty( $video['metadata']['actors'] ) ? '' : $video['metadata']['actors'];
				$clipData['startDate'] = empty( $video['time_restrictions']['start_date'] ) ? '' : strtotime( $video['time_restrictions']['start_date'] );
				$clipData['expirationDate'] = empty( $video['time_restrictions']['end_date'] ) ? '' : strtotime( $video['time_restrictions']['end_date'] );
				$clipData['regionalRestrictions'] = empty( $video['metadata']['regional_restrictions'] ) ? '' : strtoupper( $video['metadata']['regional_restrictions'] );
				$clipData['targetCountry'] = empty( $video['metadata']['targetcountry'] ) ? '' : $video['metadata']['targetcountry'];
				$clipData['source'] = empty( $video['metadata']['source'] ) ? '' : $video['metadata']['source'];
				$clipData['sourceId'] = empty( $video['metadata']['sourceid'] ) ? '' : $video['metadata']['sourceid'];
				$clipData['series'] = empty( $video['metadata']['series'] ) ? '' : $video['metadata']['series'];
				$clipData['season'] = empty( $video['metadata']['season'] ) ? '' : $video['metadata']['season'];
				$clipData['episode'] = empty( $video['metadata']['episode'] ) ? '' : $video['metadata']['episode'];
				$clipData['characters'] = empty( $video['metadata']['characters'] ) ? '' : $video['metadata']['characters'];
				$clipData['resolution'] = empty( $video['metadata']['resolution'] ) ? '' : $video['metadata']['resolution'];
				$clipData['aspectRatio'] = empty( $video['metadata']['aspectratio'] ) ? '' : $video['metadata']['aspectratio'];
				$clipData['distributor'] = empty( $video['metadata']['distributor'] ) ? '' : $video['metadata']['distributor'];
				$clipData['pageCategories'] = empty( $video['metadata']['pagecategories'] ) ? '' : $video['metadata']['pagecategories'];

				// Howdini has specific metadata which we want to map to our own
				if ( $clipData['provider'] == "ooyala/howdini" ) {
					$clipData["genres"] = $this->getHowdiniGenre( $video['metadata']['category'] );
					$clipData["category"] = "Lifestyle";
					$clipData["type"] = "How To";
					$clipData["pageCategories"] = "Lifestyle, Howdini, How To";

					// Genres need to be applied to categories VID-1787
					if ( !empty( $clipData['genres'] ) ) {
						$clipData["pageCategories"] .= ', ' . $clipData['genres'];
					}

					$ooyalaAsset = new OoyalaAsset();
					// Make sure all Howdini assets use the Howdini ad set
					$ooyalaAsset->setAdSet( $clipData["videoId"], F::app()->wg->OoyalaApiConfig['adSetHowdini'] );
				}

				$createParams = array( 'provider' => $clipData['provider'] );
				$articlesCreated += $this->createVideo( $clipData, $createParams );
			}
		} while ( !empty( $nextPage ) );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * get feed url
	 * @param array $params
	 * @param string $nextPage
	 * @return string $url
	 */
	private function initFeedUrl( $params, $nextPage ) {
		$method = 'GET';
		$reqPath = '/v2/assets';
		if ( !empty( $nextPage ) ) {
			$parsed = explode( "?", $nextPage );
			parse_str( array_pop( $parsed ), $params );
		}

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );

		return $url;
	}


	/**
	 * Create list of category names to add to the new file page
	 * @param array $categories
	 * @return array $categories
	 */
	public function generateCategories( array $categories ) {
		wfProfileIn( __METHOD__ );

		if ( !empty( $this->metaData['name'] ) ) {
			$categories = array_merge( $categories, array_map( 'trim', explode( ',', $this->metaData['name'] ) ) );
		}

		if ( !empty( $this->metaData['pageCategories'] ) ) {
			$stdCategories = array_map( array( $this , 'getPageCategory'), explode( ',', $this->metaData['pageCategories'] ) );
			$categories = array_merge( $categories, $stdCategories );
		}

		// remove 'the' category
		$key = array_search( 'the', array_map( 'strtolower', $categories ) );
		if ( $key !== false ) {
			unset( $categories[$key] );
		}

		if ( !empty( $this->metaData['categoryName'] ) ) {
			$categories[] = $this->metaData['categoryName'];
		}

		$categories = array_merge( $categories, $this->getAdditionalPageCategories( $categories ) );

		$categories[] = 'Ooyala';

		wfProfileOut( __METHOD__ );

		return wfGetUniqueArrayCI( $categories );
	}

	/**
	 * generate meatadata
	 * @param string $errorMsg
	 * @return array|integer $metadata or zero on error
	 */
	public function generateMetadata( &$errorMsg ) {
		$metadata = parent::generateMetadata( $errorMsg );
		if ( empty( $metadata ) ) {
			return 0;
		}

		$metadata['startDate'] = empty( $this->metaData['startDate'] ) ? '' :  $this->metaData['startDate'];
		$metadata['source'] = empty( $this->metaData['source'] ) ? '' :  $this->metaData['source'];
		$metadata['sourceId'] = empty( $this->metaData['sourceId'] ) ? '' :  $this->metaData['sourceId'];
		$metadata['distributor'] = empty( $this->metaData['distributor'] ) ? '' :  $this->metaData['distributor'];
		$metadata['pageCategories'] = empty( $this->metaData['pageCategories'] ) ? '' :  $this->metaData['pageCategories'];

		return $metadata;
	}

	/**
	 * Returns a genre based off of the category. This is specific to the Howdini provider. The details of this
	 * mapping can be found in Jira VID-1691
	 * @param $category
	 * @return string
	 */
	function getHowdiniGenre( $category ) {

		$category = strtolower( trim( $category ) );
		switch( $category ) {
			case "celebrations":
				$genre = "Variety";
				break;
			case "family":
				$genre = "Family";
				break;
			case "food":
				$genre = "Food and Drink";
				break;
			case "health":
				$genre = "Health";
				break;
			case "living":
				$genre = "Home";
				break;
			case "style":
				$genre = "Fashion";
				break;
			case "tech":
				$genre = "Tech";
				break;
			default:
				$genre = ucfirst( $category );
				break;
		}

		return $genre;
	}

}
