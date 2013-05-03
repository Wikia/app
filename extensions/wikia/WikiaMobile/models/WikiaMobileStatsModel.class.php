<?php
/**
 * Articles model for the WikiaMobile skin
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @author Jakub Olek <jakubolek@wikia-inc.com>
 */
class WikiaMobileStatsModel extends WikiaModel {
	const POPULAR_PAGES_CACHE_KEY = 'wikiamobilestatsmodel_poppages';
	const POPULAR_PAGES_NUMBER_LIMIT = 20;
	const POPULAR_PAGES_CACHE_TIME = 86400;

	/**
	 * Fetches the top N pages on the wiki with thumbnails
	 * used in the 404 pages implementation
	 *
	 * @author Jakub Olek <jakubolek@wikia-inc.com>
	 *
	 * @return Array[] The array of results
	 */
	public function getPopularPages(){
		wfProfileIn( __METHOD__ );
		$memKey = $this->getPopularPagesCacheKey();
		$pages = $this->wg->Memc->get( $memKey );

		if( !is_array( $pages ) || !count( $pages ) ) {
			$res = ApiService::call( array(
				'action' => 'query',
				'list' => 'wkpoppages',
				'wklimit' => self::POPULAR_PAGES_NUMBER_LIMIT
			) );

			if ( is_array( $res ) ) {
				$res = $res['query']['wkpoppages'];
				$ids = array();

				foreach( $res as $r ) {
					array_push( $ids,  $r['id'] );
				};

				//ImageServing does not return results if id is wrong
				$is = $this->app->sendRequest( 'ImageServingController', 'getImages', array(
					'ids' => $ids,
					'width' => 100,
					'height' => 100,
					'count' => 5
				));

				$pages = $is->getVal('result');

				if ( is_array( $pages ) ) {
					foreach( $pages as $key => $r){
						array_unshift( $pages[$key], $res[$key]['title']);
					}

					$this->wg->Memc->set( $memKey, $pages, self::POPULAR_PAGES_CACHE_TIME );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * Fetches a random page from the top N pages on the wiki with thumbnails
	 * used in the 404 pages implementation
	 *
	 * @author Jakub Olek <jakubolek@wikia-inc.com>
	 *
	 * @return String[]
	 * An array with the 0th element being the link to the page
	 * and the 1st element being the URL of the thumbnail
	 */
	public function getRandomPopularPage(){
		wfProfileIn( __METHOD__ );
		$pages = $this->getPopularPages();
		$useMainPage = true;
		$link = '';
		$imgUrl = '';
		$count = 0;
		$skipped = 0;
		$cachePurged = false;

		if ( is_array( $pages ) && count( $pages ) > 0 ) {
			$count = count( $pages );
			$keys = array_keys( $pages );

			for ( $i = 0; $i < $count; $i++ ) {
				$key = array_rand( $keys , 1 );
				$pageId = $keys[ $key ];
				$page = $pages[ $pageId ];
				$title = Title::newFromText( $page[0] );

				//check if $title is instanceof Title to be sure
				if ( $title instanceof Title ) {
					$link = $title->getLocalUrl();

					//get random image from a page
					//first element is a page title thus random min is 1
					$imgUrl = $page[ ( rand( 1, count( $page ) - 1)) ]['url'];
					$useMainPage = false;
					break;
				} else {
					unset( $keys[ $key ] );
				}

				$skipped++;
			}
		}

		//invalidate mem cache in case half of pages are invalid
		//in that case is worth to regenerate the whole pool
		if ( $skipped > ( $count / 2 ) ) {
			$this->wg->Memc->delete( $this->getPopularPagesCacheKey() );
			$cachePurged = true;
		}

		//if some pages were skipped report that to LOG
		if( $skipped > 0 ) {
			Wikia::log(
				'WikiaMobileErrorService',
				'getRandomPage',
				'skipped pages: ' . $skipped .
				' of ' . count( $pages ) .
				( $useMainPage ? ' (using main page)' : '' ) .
				( $cachePurged ? ' (cache purged)' : '' )
			);
		}

		//if for whatever reason all of the above fails to deliver a result
		//then get the link to the main page and show no image
		if ( $useMainPage ) {
			$link = Title::newMainPage()->getLocalUrl();
			$imgUrl = "/extensions/wikia/WikiaMobile/images/404_default.png";
		}

		wfProfileOut( __METHOD__ );
		return array( $link, $imgUrl );
	}

	private function getPopularPagesCacheKey(){
		return wfMemcKey( self::POPULAR_PAGES_CACHE_KEY );
	}
}