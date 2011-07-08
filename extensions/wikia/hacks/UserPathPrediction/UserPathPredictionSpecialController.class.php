<?php

/**
 * User Path Prediction Special page
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

class UserPathPredictionSpecialController extends WikiaSpecialPageController {
		
	private $model,$controller;	
		
	public function __construct() {
		parent::__construct( 'UserPathPrediction', '', false );
	}
	
	public function init() {
		//TODO: initialization code here
	}
	
	public function index() {
		
		$this->wg->Out->setPageTitle( "User Path Prediction Demonstration" );
		//$this->wg->Out->setPageTitle( $this->wf->msg( 'helloworld-specialpage-title' ) );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/css/UserPathPrediction.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/UserPathPrediction.js' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/tablesorter.min.js' );
		
		$this->redirect( 'UserPathPredictionSpecial', 'UserPathPrediction' );
	}
	
	
	public function UserPathPrediction() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->model = F::build( 'UserPathPredictionModel' );
		$this->controller = F::build('UserPathPredictionController');
		
		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );

		// setting response data
		$this->setVal( 'header', $this->wf->msg('header') );
		
		$result = $this->sendRequest( 'UserPathPredictionController', 'getPath');
		$result = $result->getData();
		$result = $result["articles"];

		$this->setVal( 'articles', $result );

		
		//get Wiki names	
		$wikis = $this->model->getWikis();
		$this->setVal( 'wikis', $wikis );
		
		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;

		$this->wf->profileOut( __METHOD__ );
	}
		
	public function getNodes() {
		$this->model = F::build( 'UserPathPredictionModel' );
		
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
			
		} else {
			$articleId = $this->getVal( 'article' );
		}
		
		$nodes = $this->model->getNodes($this->wg->CityId, $articleId, $this->getVal('datespan'), $this->getVal('count'));
		$resultArray;
		
		if ( count($nodes) > 0 ) {

			foreach ( $nodes as $node ) {
			
				$referrerTitle = F::build( 'Title', array( $node->referrer_id ), 'newFromID' );
				$targetTitle = F::build( 'Title', array( $node->target_id ), 'newFromID' );
				$referrerURL = $referrerTitle->getLocalURL();
				$targetURL = $targetTitle->getLocalURL();
				
				$resultArray[] = array(
						'cityid' => $node->city_id,
						'referrerTitle' => $referrerTitle,
						'referrerURL' => $referrerURL,
						'targetTitle' => $targetTitle,
						'targetURL' => $targetURL,
						'count' => $node->count,
						'updated' => $node->updated
						);
			}	

		} else {
			$resultArray = array("No Result");
		}
		$this->setVal('nodes',  $resultArray );
	}

}
