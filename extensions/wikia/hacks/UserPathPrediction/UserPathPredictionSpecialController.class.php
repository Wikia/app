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
		$this->model = F::build( 'UserPathPredictionModel' );
	}
	
	public function index() {
		
		$this->wg->Out->setPageTitle( $this->wf->Msg( 'userpathprediction-special-header' ) );
		
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/css/UserPathPrediction.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/UserPathPrediction.js' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/tablesorter.min.js' );
		
		$this->redirect( 'UserPathPredictionSpecial', 'UserPathPrediction' );
	}
	
	
	public function UserPathPrediction() {
		$this->wf->profileIn( __METHOD__ );
		
		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
		
		// setting response data
		$this->setVal( 'header', $this->wf->Msg( 'userpathprediction-special-header' ) );
		
		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;
		
		$this->wf->profileOut( __METHOD__ );
	}
		
	public function getNodes() {
		$this->wf->profileIn( __METHOD__ );
		
		//TODO move to UserPathPredictionController
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
			
		} else {
			$articleId = $this->getVal( 'article' );
		}
		
		$nodes = $this->model->getNodes($this->wg->CityId, $articleId, $this->getVal('datespan'), $this->getVal('count'));
		$result = array();
		
		if ( count( $nodes ) > 0 ) {
			foreach ( $nodes as $node ) {
				$referrerTitle = F::build( 'Title', array( $node->referrer_id ), 'newFromID' );
				$targetTitle = F::build( 'Title', array( $node->target_id ), 'newFromID' );
				
				$referrerURL = $referrerTitle->getLocalURL();
				$targetURL = $targetTitle->getLocalURL();
				
				$result[] = array(
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
			$result = array( "No Result" );
		}
		
		$this->setVal( 'nodes',  $result );
		
		$this->wf->profileOut( __METHOD__ );
	}

}
