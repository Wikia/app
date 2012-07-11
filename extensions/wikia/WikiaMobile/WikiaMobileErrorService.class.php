<?php
	/**
	 * WikiaMobileErrorService
	 * handles displying various errors to a user
	 *
	 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
	 */
class WikiaMobileErrorService extends WikiaService {

	const MEM_CACHE_KEY = 'WikiaMobileErrorService';
	const CACHE_TIME = 86400;
	const PAGES_NUMBER_LIMIT = 20;

	const PAGENOTFOUND = 'pageNotFound';

	function index(){
		$type = $this->getVal( 'type', 'pageNotFound' );
		$this->forward( 'WikiaMobileErrorService', $type, false );
	}


	/**
	 * Page Not Found
	 *
	 * Get 20 most recent edited page
	 * get 5 images per page
	 *
	 * display random image on 404 page
	 * example:
	 *
	 * Open non existent page on any wiki
	 *
	 */

	function pageNotFound(){
		$this->app->wf->profileIn( __METHOD__ );
		$css = '';
		$scssPackages =  array( 'wikiamobile_404_scss' );

		$this->memKey = $this->wf->MemcKey( WikiaMobileErrorService::MEM_CACHE_KEY, 'pages' );
		$pages = $this->wg->Memc->get( $this->memKey );

		if( !is_array( $pages ) || count( $pages ) == 0 ) {
			//we are useing most popular pages to have meaningful pages to show to a user
			$params = array(
				'action' => 'query',
				'list' => 'wkpoppages',
				'wklimit' => WikiaMobileErrorService::PAGES_NUMBER_LIMIT
			);

			$api = new ApiMain( new FauxRequest( $params ) );
			$api->execute();
			$res = $api->getResultData();

			if ( is_array( $res ) ) {
				$res = $res['query']['wkpoppages'];

				$ids = array();

				foreach( $res as $r ) {
					array_push( $ids,  $r['id'] );
				};

				//ImageServing does not return results if id is wrong
				$is = $this->sendRequest( 'ImageServingController', 'getImages', array(
					'ids' => $ids,
					'width' => 100,
					'height' => 100,
					'count' => 5
				));

				$pages = $is->getVal('result');

				foreach( $pages as $key => $r){
					array_unshift( $pages[$key], $res[$key]['title']);
				}

				$this->wg->Memc->set( $this->memKey, $pages, WikiaMobileErrorService::CACHE_TIME );
			}
		}

		foreach( F::build( 'AssetsManager', array(), 'getInstance' )->getURL( $scssPackages ) as $s ) {
			$css .= "<link rel=stylesheet href='{$s}' />";
		}

		$this->setVal( 'cssLinks', $css );
		$this->setVal( 'title', $this->wg->Out->getPageTitle() );

		$ret = $this->getRandomPage( $pages );

		$this->setVal( 'link', $ret[0] );
		$this->setVal( 'img', $ret[1] );

		$this->app->wf->profileOut( __METHOD__ );
	}

	function getRandomPage( $pages ){
		$this->app->wf->profileIn( __METHOD__ );

		$useMainPage = true;

		$count = 0;
		$skipped = 0;
		$cachePurged = false;

		//lets find image from most recent edited Article
		if ( is_array( $pages ) && count( $pages ) > 0 ) {
			$count = count( $pages );
			$keys = array_keys( $pages );

			for( $i = 0; $i < $count; $i++ ){

				$key = array_rand( $keys , 1 );
				$pageId = $keys[ $key ];

				$page = $pages[ $pageId ];

				$title = Title::newFromText( $page[0] );

				//check if $title is instanceof Title just to BE sure
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

				$skipped += 1;
			}
		}

		//delete mem cache in case half of pages are invalid
		if ( $skipped > ( $count / 2 ) ) {
			$this->wg->Memc->delete( $this->memKey, $pages, WikiaMobileErrorService::CACHE_TIME );
			$cachePurged = true;
		}

		if( $useMainPage ){
			//if for whatever reason $pages is not an array
			//get link to a main page and show no image

			$link = Title::newMainPage()->getLocalUrl();
			$imgUrl = '';
		}

		//if some pages were skipped report that to LOG
		if( $skipped > 0) {
			Wikia::log(
				'WikiaMobileErrorService',
				'getRandomPage',
				'skipped pages: ' . $skipped .
				' of ' . count( $pages ) .
				( $useMainPage ? ' (using main page)' : '' ) .
				( $cachePurged ? ' (cache purged)' : '' )
			);
		}

		$this->app->wf->profileOut( __METHOD__ );
		return array( $link, $imgUrl );
	}
}