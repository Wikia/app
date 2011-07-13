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
		$this->wf->profileIn( __METHOD__ );
		$this->model = F::build( 'UserPathPredictionModel' );
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function index() {
		$this->wf->profileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( $this->wf->Msg( 'userpathprediction-special-header' ) );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/css/UserPathPrediction.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/UserPathPrediction.js' );
		$this->redirect( 'UserPathPredictionSpecial', 'UserPathPrediction' );
		$this->wf->profileOut( __METHOD__ );
	}
	
	
	public function UserPathPrediction() {
		$this->wf->profileIn( __METHOD__ );		
		$this->setVal( 'par', $this->getVal( 'par' ) );
		$this->mIncluding = true;
		$this->wf->profileOut( __METHOD__ );
	}
		
	public function getNodes() {
		$this->wf->profileIn( __METHOD__ );
		$result = array();
		$articleIds = array();
		$thumbnailsReplaced = array();
		//TODO move to UserPathPredictionController
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
			
		} else {
			$articleId = $this->getVal( 'article' );
		}

		$nodes = $this->model->getNodes($this->wg->CityId, $articleId, $this->getVal('datespan'), $this->getVal('count'));

		
		if ( count( $nodes ) > 0 ) {
			foreach ( $nodes as $node ) {
				
				$targetTitle = F::build( 'Title', array( $node->target_id ), 'newFromID' );
				
				if($targetTitle != NULL) {
					$targetURL = $targetTitle->getLocalURL();
					$result[] = array(
						'cityid' => $node->city_id,
						'targetTitle' => $targetTitle,
						'targetURL' => $targetURL,
						'count' => $node->count,
						'updated' => $node->updated
					);
					$articleIds[] = $targetTitle->mArticleID;
				}
			}
		} else {
			$result = array( "No Result" );
		}
		
		$this->setVal( 'nodes',  $result );
		
		$thumbnails = $this->sendRequest( 'UserPathPredictionService', 'getThumbnails', array( 'articleIds' => $articleIds, 'width' => 75 ) );
		$thumbnails = $thumbnails->getVal('thumbnails');
		
		foreach ( $thumbnails as $key => $thumbnail ) {
			$thumbnail[0]['url'] = str_replace("http://images.jolek.wikia-dev.com", "http://images2.wikia.nocookie.net", $thumbnail[0]['url']);
			$thumbnailsReplaced[$key] = $thumbnail;
		
		}
		$this->setVal( 'thumbnails', $thumbnailsReplaced );
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function getRelated() {
		$this->wf->profileIn( __METHOD__ );
		$result = array();
		$articleIds = array();
		$thumbnailsReplaced = array();
		
		//TODO move to UserPathPredictionController
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
		} else {
			$articleId = $this->getVal( 'article' );
		}

		$nodes = $this->model->getRelated($this->wg->CityId, $articleId, $this->getVal('datespan'));


		if ( count( $nodes ) > 0 ) {
			foreach ( $nodes as $node ) {
			
				$targetTitle = F::build( 'Title', array( $node->target_id ), 'newFromID' );

				if($targetTitle != NULL) {
					$targetURL = $targetTitle->getLocalURL();
					$result[] = array(
						'cityid' => $node->city_id,
						'targetTitle' => $targetTitle,
						'targetURL' => $targetURL,
						'count' => $node->count,
						'updated' => $node->updated
					);
					$articleIds[] = $targetTitle->mArticleID;
				}
			}
		} else {
			$result = array( "No Result" );
		}
		$this->setVal( 'nodes',  $result );
		$thumbnails = $this->sendRequest( 'UserPathPredictionService', 'getThumbnails', array( 'articleIds' => $articleIds, 'width' => 100 ) );
		$thumbnails = $thumbnails->getVal('thumbnails');

		foreach ( $thumbnails as $key => $thumbnail ) {
			$thumbnail[0]['url'] = str_replace("http://images.jolek.wikia-dev.com", "http://images2.wikia.nocookie.net", $thumbnail[0]['url']);
			$thumbnailsReplaced[$key] = $thumbnail;
		
		}
		$this->setVal( 'thumbnails', $thumbnailsReplaced );
		$this->wf->profileOut( __METHOD__ );
	}

}
