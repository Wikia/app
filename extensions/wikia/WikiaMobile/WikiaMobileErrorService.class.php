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

		$memKey = $this->wf->MemcKey( WikiaMobileErrorService::MEM_CACHE_KEY, 'pages' );
		$pages = $this->wg->Memc->get( $memKey );

		if( !is_array( $pages ) ) {
			$params = array(
				'action' => 'query',
				'list' => 'recentchanges',
				'rcnamespace' => 0,
				'rclimit' => WikiaMobileErrorService::PAGES_NUMBER_LIMIT
			);

			$api = new ApiMain( new FauxRequest( $params ) );
			$api->execute();
			$res = $api->getResultData();

			if ( is_array( $res ) ) {
				$res = $res['query']['recentchanges'];

				$ids = array();

				foreach( $res as $r ) {
					array_push( $ids,  $r['pageid'] );
				};

				$ids = array_unique( $ids );

				$is = $this->sendRequest( 'ImageServingController', 'getImages', array(
					'ids' => $ids,
					'width' => 100,
					'height' => 100,
					'count' => 5
				));

				$pages = $is->getVal('result');

				$this->wg->Memc->set( $memKey, $pages, WikiaMobileErrorService::CACHE_TIME );
			}
		}

		foreach( F::build( 'AssetsManager', array(), 'getInstance' )->getURL( $scssPackages ) as $s ) {
			$css .= "<link rel=stylesheet href='{$s}' />";
		}

		$this->setVal( 'cssLinks', $css );
		$this->setVal( 'title', $this->wg->Out->getPageTitle() );

		//lets find image from most recent edited Article
		if ( is_array( $pages ) ) {
			$pageId = array_rand( $pages, 1 );
			$img = array_rand( $pages[$pageId], 1);

			$link = Title::newFromID( $pageId )->getLocalUrl();
			$imgUrl = $pages[$pageId][$img]['url'];
		} else {
			//if for whatever reason $pages is not an array
			//get link to a main page and show no image
			$link = Title::newMainPage()->getLocalUrl();
			$imgUrl = '';
		}

		$this->setVal( 'link', $link );
		$this->setVal( 'img', $imgUrl );

		$this->app->wf->profileOut( __METHOD__ );
	}
}