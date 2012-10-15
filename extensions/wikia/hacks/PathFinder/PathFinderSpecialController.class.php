<?php

/**
 * Path Finder special page
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

class PathFinderSpecialController extends WikiaSpecialPageController {
		
	private $model,$controller;	
		
	public function __construct() {
		parent::__construct( 'PathFinder', '', false );
	}
	
	public function init() {
		$this->wf->profileIn( __METHOD__ );
		$this->model = F::build( 'PathFinderModel' );
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function index() {
		$this->wf->profileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( $this->wf->Msg( 'pathfinder-special-header' ) );
		$this->response->addAsset( 'extensions/wikia/hacks/PathFinder/css/PathFinder.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/PathFinder/js/PathFinder.js' );
		$this->forward( 'PathFinderSpecial', 'PathFinder' );
		$this->wf->profileOut( __METHOD__ );
	}
	
	
	public function PathFinder() {
		$this->wf->profileIn( __METHOD__ );		
		$this->setVal( 'par', $this->getVal( 'par' ) );
		$this->mIncluding = true;
		$this->wf->profileOut( __METHOD__ );
	}
		
	public function getNodes() {
		$this->wf->profileIn( __METHOD__ );
		$path = array();
		$result = array();
		$articleIds = array();
		$thumbnailURLs = array();
		//TODO move to PathFinderController
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
			
		} else {
			$articleId = $this->getVal( 'article' );
		}

		$paths = $this->model->getNodes( $this->wg->CityId, $articleId, $this->getVal( 'datespan' ), $this->getVal( 'count' ), $this->getVal( 'pathsNumber' ), $this->getVal( 'minCount' ) );

		if ( count( $paths ) > 0 ) {
			
			foreach ( $paths as $nodes ) {
				
				foreach ( $nodes as $node ) {

					$targetTitle = F::build( 'Title', array( $node->target_id ), 'newFromID' );
					
					if( $targetTitle != NULL ) {

						$targetURL = $targetTitle->getLocalURL();
						$path[] = array(
							'cityid' => $node->city_id,
							'targetTitle' => $targetTitle,
							'targetURL' => $targetURL,
							'count' => $node->count,
							'updated' => $node->updated
						);
						
						$articleIds[] = $targetTitle->mArticleID;
					}
				}
				$result[] = $path;
				$path = array();
			}
			
			$thumbnails = $this->sendSelfRequest(
				'getThumbnails',
				array( 'articleIds' => $articleIds, 'width' => 75 )
			)->getVal( 'thumbnails' );
			
			$this->setVal( 'thumbnails', $thumbnails );
		} else {
			$result = array( "No Result" );
		}
		
		$this->setVal( 'paths',  $result );
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function getRelated() {
		$this->wf->profileIn( __METHOD__ );
		$result = array();
		$articleIds = array();
		$thumbnailsReplaced = array();
		
		//TODO move to PathFinderController
		if ( $this->getVal( 'selectby' ) == 'byTitle' ) {
			$title = F::build( 'Title', array( $this->getVal( 'article' ) ), 'newFromText' );
			$articleId = $title->getArticleID();
		} else {
			$articleId = $this->getVal( 'article' );
		}
		
		$nodes = $this->model->getRelated($this->wg->CityId, $articleId, $this->getVal( 'datespan' ), $this->getVal( 'userHaveSeenNumber' ), $this->getVal( 'minCount' ) );
		
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
			
			$thumbnails = $this->sendSelfRequest(
				'getThumbnails',
				array( 'articleIds' => $articleIds, 'width' => 75 )
			)->getVal('thumbnails');
			
			$this->setVal( 'thumbnails', $thumbnails );
			
		} else {
			$result = array( "No Result" );
		}
		
		$this->setVal( 'nodes',  $result );
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function getThumbnails( $articleIds = null, $width = null ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		$articleIds = ( !empty( $articleIds ) ) ? $articleIds : $this->getVal( 'articleIds' );
		$width = ( !empty( $width ) ) ? $width : $this->getVal( 'width' );
		
		$source = new ImageServing(
			$articleIds,
			$width,
			array(
				"w" => 3,
				"h" => 2
			)
		);
		
		$result = $source->getImages( 1 );
		$this->setVal( 'thumbnails', $result );
		
		$this->app->wf->profileOut( __METHOD__ );
		return $result;	
	}
}
